<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;
use App\Models\Category;
use App\Models\Regency;
use App\Models\User;
use App\Models\Photo;

class WisataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan User Penulis/Admin Tersedia
        $user = User::where('role', 'admin')->first() 
                ?? User::where('role', 'contributor')->first() 
                ?? User::first() 
                ?? User::factory()->create();

        // 2. Pastikan Kategori Wisata Tersedia
        $categoryWisata = Category::firstOrCreate(
            ['slug' => 'wisata'],
            ['name' => 'Wisata']
        );

        // 3. Pastikan Kabupaten Terdaftar
        $bangkalan = Regency::firstOrCreate(['slug' => 'bangkalan'], ['name' => 'Bangkalan', 'img' => 'images/culture/culture04.jpg']);
        $sampang   = Regency::firstOrCreate(['slug' => 'sampang'],   ['name' => 'Sampang',   'img' => 'images/culture/culture05.jpg']);
        $pamekasan = Regency::firstOrCreate(['slug' => 'pamekasan'], ['name' => 'Pamekasan', 'img' => 'images/culture/culture06.jpg']);
        $sumenep   = Regency::firstOrCreate(['slug' => 'sumenep'],   ['name' => 'Sumenep',   'img' => 'images/culture/culture07.jpg']);

        // Data tempat wisata terkurasi di Madura dengan variasi foto acak & bervariasi
        $wisataList = [
            // BANGKALAN
            [
                'regency_id'  => $bangkalan->id,
                'title'       => 'Bukit Jaddih Bangkalan',
                'slug'        => 'bukit-jaddih-bangkalan',
                'description' => 'Bukit Jaddih merupakan destinasi wisata alam bernuansa tambang kapur putih yang spektakuler di Bangkalan. Pemandangan tebing kapur raksasa bernuansa artistik dipadukan dengan danau alami berwarna hijau toska (Goa Pote) di tengah kawasan menjadikan lokasi ini tempat favorit foto dan rekreasi.',
                'address'     => 'Desa Jaddih, Kecamatan Socah, Kabupaten Bangkalan',
                'maps_url'    => 'https://maps.google.com/?q=Bukit+Jaddih+Bangkalan',
                'open_time'   => '07:00:00',
                'close_time'  => '17:00:00',
                'view_count'  => 14200,
                'photos'      => ['images/culture/culture04.jpg', 'images/culture/culture02.jpg', 'images/culture/culture08-old.jpg'],
            ],
            [
                'regency_id'  => $bangkalan->id,
                'title'       => 'Mercusuar Sembilangan',
                'slug'        => 'mercusuar-sembilangan-bangkalan',
                'description' => 'Mercusuar Sembilangan adalah cagar budaya bersejarah peninggalan kolonial Belanda yang didirikan pada tahun 1879. Memiliki ketinggian 65 meter dengan 16 lantai, pengunjung dapat menikmati panorama perairan Selat Madura dan lanskap pesisir Bangkalan dari ketinggian.',
                'address'     => 'Desa Sembilangan, Kecamatan Bangkalan, Kabupaten Bangkalan',
                'maps_url'    => 'https://maps.google.com/?q=Mercusuar+Sembilangan',
                'open_time'   => '08:00:00',
                'close_time'  => '17:00:00',
                'view_count'  => 8900,
                'photos'      => ['images/culture/culture03.jpg', 'images/culture/culture01.jpg', 'images/culture/culture07-old.jpg'],
            ],
            [
                'regency_id'  => $bangkalan->id,
                'title'       => 'Taman Rekreasi Kota (TRK) Bangkalan',
                'slug'        => 'taman-rekreasi-kota-bangkalan',
                'description' => 'Taman Rekreasi Kota (TRK) Bangkalan merupakan destinasi wisata keluarga yang asri dan sejuk tepat di jantung kota Bangkalan. Dilengkapi dengan kolam renang, taman bermain anak, area kolam pancing, serta rimbunan pepohonan rindang.',
                'address'     => 'Jl. Soekarno Hatta, Kecamatan Bangkalan, Kabupaten Bangkalan',
                'maps_url'    => 'https://maps.google.com/?q=TRK+Bangkalan',
                'open_time'   => '07:00:00',
                'close_time'  => '18:00:00',
                'view_count'  => 5600,
                'photos'      => ['images/culture/culture05.jpg', 'images/culture/culture06-old.jpg', 'images/culture/culture02.jpg'],
            ],

            // SAMPANG
            [
                'regency_id'  => $sampang->id,
                'title'       => 'Air Terjun Toroan',
                'slug'        => 'air-terjun-toroan-sampang',
                'description' => 'Air Terjun Toroan memiliki keunikan alam yang langka karena bermuara dan jatuh langsung ke bibir laut Selat Madura. Dikelilingi rimbunan pepohonan dan batuan karang alami, udara yang sejuk dan deburan ombak berpadu dengan gemericik air tawar menciptakan suasana yang sangat menyegarkan.',
                'address'     => 'Desa Ketapang Daya, Kecamatan Ketapang, Kabupaten Sampang',
                'maps_url'    => 'https://maps.google.com/?q=Air+Terjun+Toroan',
                'open_time'   => '06:00:00',
                'close_time'  => '18:00:00',
                'view_count'  => 16800,
                'photos'      => ['images/culture/culture06.jpg', 'images/culture/culture08.jpg', 'images/pantai.png'],
            ],
            [
                'regency_id'  => $sampang->id,
                'title'       => 'Pantai Camplong',
                'slug'        => 'pantai-camplong-sampang',
                'description' => 'Pantai Camplong merupakan salah satu objek wisata bahari paling terkenal di Kabupaten Sampang. Memiliki garis pantai yang luas dengan ombak yang landai, pohon cemara udang yang meneduhkan, serta wahana wisata air yang menyenangkan untuk seluruh keluarga.',
                'address'     => 'Desa Dharma Camplong, Kecamatan Camplong, Kabupaten Sampang',
                'maps_url'    => 'https://maps.google.com/?q=Pantai+Camplong',
                'open_time'   => '06:00:00',
                'close_time'  => '18:30:00',
                'view_count'  => 11300,
                'photos'      => ['images/pantai.png', 'images/culture/culture05.jpg', 'images/culture/culture06.jpg'],
            ],
            [
                'regency_id'  => $sampang->id,
                'title'       => 'Hutan Kera Nepa',
                'slug'        => 'hutan-kera-nepa-sampang',
                'description' => 'Hutan Kera Nepa menyajikan wisata edukasi alam liar yang alami. Terletak di tepi muara sungai dan pantai utara Sampang, kawasan hutan ini dihuni oleh ratusan kera alami yang dijaga keasriannya oleh masyarakat lokal.',
                'address'     => 'Desa Nepa, Kecamatan Banyuates, Kabupaten Sampang',
                'maps_url'    => 'https://maps.google.com/?q=Hutan+Kera+Nepa',
                'open_time'   => '07:00:00',
                'close_time'  => '17:00:00',
                'view_count'  => 7200,
                'photos'      => ['images/culture/culture07-old.jpg', 'images/culture/culture01.jpg', 'images/culture/culture03.jpg'],
            ],

            // PAMEKASAN
            [
                'regency_id'  => $pamekasan->id,
                'title'       => 'Api Tak Kunjung Padam',
                'slug'        => 'api-tak-kunjung-padam-pamekasan',
                'description' => 'Api Tak Kunjung Padam merupakan fenomena geologi alami yang unik di Kabupaten Pamekasan. Semburan gas alam murni dari dalam tanah memicu munculnya kobaran api abadi yang tak pernah padam meskipun diterjang angin kencang maupun guyuran hujan.',
                'address'     => 'Desa Larangan Tokol, Kecamatan Tlanakan, Kabupaten Pamekasan',
                'maps_url'    => 'https://maps.google.com/?q=Api+Tak+Kunjung+Padam',
                'open_time'   => '00:00:00',
                'close_time'  => '23:59:59',
                'view_count'  => 19500,
                'photos'      => ['images/culture/culture07.jpg', 'images/culture/culture02.jpg', 'images/culture/culture04.jpg'],
            ],
            [
                'regency_id'  => $pamekasan->id,
                'title'       => 'Pantai Jumiang',
                'slug'        => 'pantai-jumiang-pamekasan',
                'description' => 'Pantai Jumiang terkenal dengan keindahan tebing-tebing tinggi yang menghadap langsung ke lautan lepas. Pengunjung dapat menikmati pemandangan perbukitan hijau, hamparan pasir putih, serta spot sunrise yang menawan.',
                'address'     => 'Desa Tanjung, Kecamatan Pademawu, Kabupaten Pamekasan',
                'maps_url'    => 'https://maps.google.com/?q=Pantai+Jumiang',
                'open_time'   => '06:00:00',
                'close_time'  => '17:30:00',
                'view_count'  => 9400,
                'photos'      => ['images/culture/culture08.jpg', 'images/pantai.png', 'images/culture/culture05.jpg'],
            ],
            [
                'regency_id'  => $pamekasan->id,
                'title'       => 'Kampung Batik Klampar',
                'slug'        => 'kampung-batik-klampar-pamekasan',
                'description' => 'Kampung Batik Klampar adalah pusat kerajinan Batik Tulis Madura yang ternama di Pamekasan. Pengunjung dapat melihat langsung proses pembuatan batik tradisional dengan motif tajam berani serta belanja produk batik berkualitas khas Pamekasan.',
                'address'     => 'Desa Klampar, Kecamatan Proppo, Kabupaten Pamekasan',
                'maps_url'    => 'https://maps.google.com/?q=Kampung+Batik+Klampar',
                'open_time'   => '08:00:00',
                'close_time'  => '16:00:00',
                'view_count'  => 6300,
                'photos'      => ['images/culture/culture01.jpg', 'images/culture/culture03.jpg', 'images/culture/culture07.jpg'],
            ],

            // SUMENEP
            [
                'regency_id'  => $sumenep->id,
                'title'       => 'Pantai Sembilan Gili Genting',
                'slug'        => 'pantai-sembilan-sumenep',
                'description' => 'Pantai Sembilan berada di Pulau Gili Genting Sumenep. Memiliki pasir putih super halus, air laut bening biru kristal, dan lekukan pasir alami berbentuk angka 9. Sangat populer untuk snorkeling, olahraga air, dan berkemah.',
                'address'     => 'Pulau Gili Genting, Kabupaten Sumenep',
                'maps_url'    => 'https://maps.google.com/?q=Pantai+Sembilan+Gili+Genting',
                'open_time'   => '06:00:00',
                'close_time'  => '18:00:00',
                'view_count'  => 22400,
                'photos'      => ['images/culture/culture06-old.jpg', 'images/pantai.png', 'images/culture/culture08.jpg'],
            ],
            [
                'regency_id'  => $sumenep->id,
                'title'       => 'Gili Iyang (Pulau Oksigen)',
                'slug'        => 'gili-iyang-pulau-oksigen-sumenep',
                'description' => 'Gili Iyang terkenal karena dinobatkan sebagai pulau dengan kadar konsentrasi oksigen terbaik kedua di dunia setelah Laut Mati Yordania. Menawarkan keasrian udara paling bersih, tebing karang tepi laut, dan tebing gua tebing karang yang alami.',
                'address'     => 'Kecamatan Dungkek, Kabupaten Sumenep',
                'maps_url'    => 'https://maps.google.com/?q=Gili+Iyang+Sumenep',
                'open_time'   => '06:00:00',
                'close_time'  => '17:00:00',
                'view_count'  => 18900,
                'photos'      => ['images/culture/culture08-old.jpg', 'images/culture/culture06.jpg', 'images/culture/culture01.jpg'],
            ],
            [
                'regency_id'  => $sumenep->id,
                'title'       => 'Keraton dan Museum Sumenep',
                'slug'        => 'keraton-dan-museum-sumenep',
                'description' => 'Keraton Sumenep merupakan istana peninggalan Adipati Sumenep masa lalu dengan perpaduan arsitektur Eropa, Cina, dan Jawa yang megah. Di kompleks keraton terdapat museum peninggalan sejarah kerajaan seperti Kereta Kencana dan Al-Qur\'an raksasa tulis tangan.',
                'address'     => 'Jl. Dr. Sutomo No. 6, Pajagalan, Kota Sumenep, Kabupaten Sumenep',
                'maps_url'    => 'https://maps.google.com/?q=Keraton+Sumenep',
                'open_time'   => '07:30:00',
                'close_time'  => '15:30:00',
                'view_count'  => 12100,
                'photos'      => ['images/culture/culture02.jpg', 'images/culture/culture03.jpg', 'images/culture/culture04.jpg'],
            ],
        ];

        foreach ($wisataList as $item) {
            $photos = $item['photos'];
            unset($item['photos']);

            $content = Content::updateOrCreate(
                ['slug' => $item['slug']],
                array_merge($item, [
                    'user_id'      => $user->id,
                    'category_id'  => $categoryWisata->id,
                    'status'       => 'approved',
                    'was_approved' => true,
                ])
            );

            // Bersihkan foto lama milik tempat ini
            Photo::where('content_id', $content->id)->delete();

            // Seed foto-foto variatif baru
            foreach ($photos as $index => $photoPath) {
                Photo::create([
                    'content_id' => $content->id,
                    'file_path'  => $photoPath,
                    'is_primary' => ($index === 0),
                ]);
            }
        }
    }
}
