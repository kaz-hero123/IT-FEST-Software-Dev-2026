<?php

namespace App\Services;

use App\Models\Content;

class SmartPredictorService
{
    /**
     * Kalkulasi rekomendasi destinasi menggunakan algoritma Simple Additive Weighting (SAW).
     * Kriteria (C):
     * C1 = Tingkat Ramah Lingkungan (Eco-Score) -> Berasal dari kategori (Benefit)
     * C2 = Popularitas -> Berasal dari view_count (Bisa Benefit atau Cost tergantung prioritas)
     *
     * @param  array{priority: string, category: string, regency: string}  $preferences
     * @return \Illuminate\Support\Collection<int, array{content: Content, eco_index: int, view_count: int, match_percentage: int, final_score: float}>
     */
    public function predict(array $preferences)
    {
        $priority = $preferences['priority'] ?? 'bebas';
        $category = $preferences['category'] ?? 'semua';
        $regency  = $preferences['regency'] ?? 'semua';

        // 1. Ambil data kandidat (hanya yang approved)
        $query = Content::with(['category', 'regency', 'primaryPhoto'])
            ->where('status', 'approved');

        if ($category !== 'semua') {
            $query->whereHas('category', fn($q) => $q->where('slug', $category));
        }
        
        if ($regency !== 'semua') {
            $query->whereHas('regency', fn($q) => $q->where('slug', $regency));
        }

        $candidates = $query->get();

        if ($candidates->isEmpty()) {
            return collect([]);
        }

        // 2. Tentukan Bobot (W) berdasarkan prioritas
        // C1 = Eco Score, C2 = Popularitas
        $weights = [
            'C1' => 0.5,
            'C2' => 0.5,
        ];

        // Sifat kriteria: benefit (makin besar makin bagus) atau cost (makin kecil makin bagus)
        $isC2Benefit = true; 

        if ($priority === 'sepi') {
            // Anti-Mainstream: C2 menjadi Cost (dicari yang paling sepi)
            $weights['C1'] = 0.3;
            $weights['C2'] = 0.7;
            $isC2Benefit = false;
        } elseif ($priority === 'eco') {
            // Ramah Lingkungan: C1 dimaksimalkan
            $weights['C1'] = 0.8;
            $weights['C2'] = 0.2;
            $isC2Benefit = true;
        } elseif ($priority === 'populer') {
            // Populer: C2 dimaksimalkan
            $weights['C1'] = 0.2;
            $weights['C2'] = 0.8;
            $isC2Benefit = true;
        }

        // 3. Mapping Nilai Kriteria untuk tiap kandidat
        $matrix = [];
        $maxC1 = 0; $minC1 = PHP_INT_MAX;
        $maxC2 = 0; $minC2 = PHP_INT_MAX;

        foreach ($candidates as $item) {
            // Hitung Eco-Score Dasar berdasar Kategori (Statik & Aman, tak pakai data fiktif)
            $catSlug = $item->category->slug ?? '';
            $baseEco = match($catSlug) {
                'wisata' => 90,
                'spot-foto' => 75,
                'sejarah' => 80,
                'religi' => 80,
                default => 50, // Kuliner & UMKM
            };
            
            $c1 = $baseEco;
            $c2 = $item->view_count ?? 0;

            $matrix[$item->id] = [
                'item' => $item,
                'C1' => $c1,
                'C2' => $c2
            ];

            // Cari Min/Max untuk Normalisasi
            if ($c1 > $maxC1) $maxC1 = $c1;
            if ($c1 < $minC1) $minC1 = $c1;
            
            if ($c2 > $maxC2) $maxC2 = $c2;
            if ($c2 < $minC2) $minC2 = $c2;
        }

        // Hindari pembagian dengan 0
        if ($maxC1 == 0) $maxC1 = 1;
        if ($maxC2 == 0) $maxC2 = 1;
        if ($minC2 == 0 && !$isC2Benefit) $minC2 = 1; 

        // 4. Normalisasi Matrix & Hitung Skor Akhir
        $results = [];
        foreach ($matrix as $id => $data) {
            $c1 = $data['C1'];
            $c2 = $data['C2'];

            // Normalisasi C1 (Selalu Benefit)
            $normC1 = $c1 / $maxC1;

            // Normalisasi C2 (Benefit atau Cost)
            if ($isC2Benefit) {
                $normC2 = $c2 / $maxC2;
            } else {
                // Cost formula: Min / Value
                // Jika value = 0, beri skor maksimal (1.0) karena itu yg paling sepi
                $normC2 = ($c2 == 0) ? 1.0 : ($minC2 / $c2);
                if ($normC2 > 1) $normC2 = 1.0;
            }

            // Hitung skor SAW: sum of (Weight * Normalized Value)
            $finalScore = ($weights['C1'] * $normC1) + ($weights['C2'] * $normC2);
            
            // Konversi ke persentase match
            $matchPercentage = round($finalScore * 100);

            $results[] = [
                'content' => $data['item'],
                'eco_index' => $c1,
                'view_count' => $c2,
                'match_percentage' => $matchPercentage,
                'final_score' => $finalScore
            ];
        }

        // 5. Urutkan berdasarkan skor akhir tertinggi
        usort($results, fn($a, $b) => $b['final_score'] <=> $a['final_score']);

        // 6. Ambil Top 3
        return collect(array_slice($results, 0, 3));
    }
}
