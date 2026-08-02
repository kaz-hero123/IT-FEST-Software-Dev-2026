<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmartPredictorService;
use App\Models\Category;
use App\Models\Regency;

class PredictorController extends Controller
{
    protected SmartPredictorService $predictor;

    public function __construct(SmartPredictorService $predictor)
    {
        $this->predictor = $predictor;
    }

    /**
     * Tampilkan halaman kuis Smart Predictor
     */
    public function index()
    {
        $categories = Category::all();
        $regencies = Regency::all();
        
        return view('pages.user.predictor.index', compact('categories', 'regencies'));
    }

    /**
     * Hitung prediksi menggunakan algoritma SAW
     */
    public function predict(Request $request)
    {
        $validated = $request->validate([
            'priority' => 'required|in:sepi,eco,populer,bebas',
            'category' => 'required|string',
            'regency'  => 'required|string',
        ]);

        $results = $this->predictor->predict($validated);

        return response()->json([
            'success' => true,
            'data' => $results,
            'message' => 'Rekomendasi berhasil dikalkulasi berdasarkan metrik popularitas dan kategori.'
        ]);
    }
}
