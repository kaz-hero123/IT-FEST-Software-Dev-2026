<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;
use App\Models\Category;
use App\Models\Regency;
use App\Models\User;
use App\Models\Photo;
use Illuminate\Support\Facades\Hash;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        // Tambah kontributor demo untuk variasi
        $contributors = [];
        $contributorData = [
            ['name' => 'Ahmad Fauzi',     'email' => 'ahmad.fauzi@demo.com'],
            ['name' => 'Siti Aisyah',     'email' => 'siti.aisyah@demo.com'],
            ['name' => 'Mohammad Rizki',  'email' => 'moh.rizki@demo.com'],
            ['name' => 'Nurul Hidayah',   'email' => 'nurul.h@demo.com'],
        ];

        foreach ($contributorData as $c) {
            $contributors[] = User::firstOrCreate(
                ['email' => $c['email']],
                [
                    'name'     => $c['name'],
                    'password' => Hash::make('password'),
                    'role'     => 'contributor',
                ]
            );
        }

        // Ambil regencies
        $bangkalan = Regency::where('slug', 'bangkalan')->first();
        $sampang   = Regency::where('slug', 'sampang')->first();
        $pamekasan = Regency::where('slug', 'pamekasan')->first();
        $sumenep   = Regency::where('slug', 'sumenep')->first();

        // Ambil categories
        $kuliner  = Category::where('slug', 'kuliner')->first();
        $umkm     = Category::where('slug', 'umkm')->first();
        $spotFoto = Category::where('slug', 'spot-foto')->first();

        // === KULINER ===
        $kulinerList = [
            [
                'user_id'     => $contributors[0]->id,
                'category_id' => $kuliner->id,
                'regency_id'  => $bangkalan->id,
                'title'       => 'Bebek Sinjay Bangkalan',
                'slug'        => 'bebek-sinjay-bangkalan',
                'description' => 'Bebek Sinjay adalah kuliner ikonik Bangkalan yang sudah terkenal hingga ke luar Madura. Bebek dimasak dengan bumbu rempah khas Madura yang kaya, digoreng kering sempurna hingga tulangnya pun renyah. Disajikan dengan sambal pencit (mangga muda) yang pedas segar dan lalapan. Setiap cabang selalu ramai pengunjung dari pagi hingga sore.',
                'address'     => 'Jl. Halim Perdanakusuma, Bangkalan',
                'maps_url'    => 'https://maps.google.com/?q=Bebek+Sinjay+Bangkalan',
                'open_time'   => '08:00:00',
                'close_time'  => '21:00:00',
                'view_count'  => 9800,
                'photos'      => ['images/food.png', 'images/culture/culture04.jpg'],
            ],
            [
                'user_id'     => $contributors[1]->id,
                'category_id' => $kuliner->id,
                'regency_id'  => $sampang->id,
                'title'       => 'Soto Madura Pak Nyak Sampang',
                'slug'        => 'soto-madura-pak-nyak-sampang',
                'description' => 'Soto Madura Pak Nyak adalah warung legendaris di Sampang yang sudah beroperasi lebih dari 30 tahun. Kuah kuning kental dengan potongan daging sapi empuk, perkedel kentang, dan taburan bawang goreng. Disajikan dengan nasi putih hangat dan kerupuk rambak. Rasa autentik yang tak berubah sejak generasi pertama.',
                'address'     => 'Jl. Jaksa Agung Suprapto, Sampang',
                'maps_url'    => 'https://maps.google.com/?q=Soto+Madura+Sampang',
                'open_time'   => '06:00:00',
                'close_time'  => '14:00:00',
                'view_count'  => 7200,
                'photos'      => ['images/food.png', 'images/culture/culture05.jpg'],
            ],
            [
                'user_id'     => $contributors[2]->id,
                'category_id' => $kuliner->id,
                'regency_id'  => $pamekasan->id,
                'title'       => 'Nasi Serpang Pamekasan',
                'slug'        => 'nasi-serpang-pamekasan',
                'description' => 'Nasi Serpang adalah makanan khas Pamekasan yang unik — nasi putih pulen disajikan dengan lauk ikan tongkol bumbu kuning, sayur lodeh, sambal terasi, dan kerupuk gendar. Dibungkus daun pisang yang memberikan aroma khas. Biasa disajikan saat acara adat dan kini tersedia di warung-warung lokal sebagai sarapan favorit warga.',
                'address'     => 'Pasar Kolpajung, Pamekasan',
                'maps_url'    => 'https://maps.google.com/?q=Pasar+Kolpajung+Pamekasan',
                'open_time'   => '05:30:00',
                'close_time'  => '11:00:00',
                'view_count'  => 4500,
                'photos'      => ['images/food.png', 'images/culture/culture06.jpg'],
            ],
            [
                'user_id'     => $contributors[3]->id,
                'category_id' => $kuliner->id,
                'regency_id'  => $sumenep->id,
                'title'       => 'Kaldu Kokot Sumenep',
                'slug'        => 'kaldu-kokot-sumenep',
                'description' => 'Kaldu Kokot adalah hidangan khas Sumenep yang terbuat dari kaki sapi yang dimasak lama hingga kolagen meresap sempurna ke dalam kuah. Bumbu rempah Madura yang kaya menghasilkan kaldu yang gurih dan hangat. Disajikan dengan lontong atau nasi putih, cocok untuk menghangatkan badan di pagi hari. Warung-warung di sekitar Pasar Anom Sumenep menjadi tempat favorit mencicipi hidangan ini.',
                'address'     => 'Sekitar Pasar Anom, Kota Sumenep',
                'maps_url'    => 'https://maps.google.com/?q=Pasar+Anom+Sumenep',
                'open_time'   => '05:00:00',
                'close_time'  => '10:00:00',
                'view_count'  => 5600,
                'photos'      => ['images/food.png', 'images/culture/culture07.jpg'],
            ],
        ];

        // === UMKM ===
        $umkmList = [
            [
                'user_id'     => $contributors[0]->id,
                'category_id' => $umkm->id,
                'regency_id'  => $bangkalan->id,
                'title'       => 'Kerajinan Ukir Kayu Arosbaya',
                'slug'        => 'kerajinan-ukir-kayu-arosbaya',
                'description' => 'Desa Arosbaya di Bangkalan terkenal dengan kerajinan ukir kayu yang telah menjadi warisan turun-temurun. Pengrajin lokal menghasilkan karya seni ukir pada furniture, panel dekorasi, dan souvenir dengan motif khas Madura yang detail dan artistik. Setiap produk dikerjakan secara handmade menggunakan kayu jati pilihan. Pengunjung bisa melihat langsung proses pembuatan dan membeli produk langsung dari pengrajin.',
                'address'     => 'Desa Arosbaya, Kecamatan Arosbaya, Bangkalan',
                'maps_url'    => 'https://maps.google.com/?q=Arosbaya+Bangkalan',
                'open_time'   => '08:00:00',
                'close_time'  => '17:00:00',
                'view_count'  => 3200,
                'photos'      => ['images/culture/culture01.jpg', 'images/culture/culture03.jpg'],
            ],
            [
                'user_id'     => $contributors[1]->id,
                'category_id' => $umkm->id,
                'regency_id'  => $pamekasan->id,
                'title'       => 'Batik Tulis Pamekasan',
                'slug'        => 'batik-tulis-pamekasan-umkm',
                'description' => 'UMKM Batik Tulis Pamekasan merupakan sentra produksi batik tulis tangan yang menjadi kebanggaan Madura. Motif-motif khas seperti "Sekar Jagad", "Pucuk Rebung", dan "Ramo" dikerjakan oleh pengrajin perempuan lokal dengan teknik canting tradisional. Setiap lembar kain membutuhkan waktu 2-4 minggu untuk diselesaikan. Produk tersedia mulai dari kain, kemeja, hingga aksesori fashion.',
                'address'     => 'Kecamatan Proppo, Pamekasan',
                'maps_url'    => 'https://maps.google.com/?q=Batik+Tulis+Pamekasan',
                'open_time'   => '08:00:00',
                'close_time'  => '16:00:00',
                'view_count'  => 4100,
                'photos'      => ['images/culture/culture01.jpg', 'images/culture/culture02.jpg'],
            ],
            [
                'user_id'     => $contributors[2]->id,
                'category_id' => $umkm->id,
                'regency_id'  => $sumenep->id,
                'title'       => 'Garam Rakyat Sumenep',
                'slug'        => 'garam-rakyat-sumenep',
                'description' => 'Sumenep adalah produsen garam terbesar di Jawa Timur. UMKM garam rakyat di pesisir Sumenep mengolah garam secara tradisional menggunakan metode penguapan alami di tambak-tambak garam. Produk garam lokal kini dikembangkan menjadi garam premium, garam spa, dan garam rempah yang bernilai jual tinggi. Mendukung ekonomi nelayan dan petani garam pesisir.',
                'address'     => 'Pesisir Kalianget, Kabupaten Sumenep',
                'maps_url'    => 'https://maps.google.com/?q=Garam+Kalianget+Sumenep',
                'open_time'   => '07:00:00',
                'close_time'  => '16:00:00',
                'view_count'  => 3800,
                'photos'      => ['images/culture/culture08.jpg', 'images/culture/culture06.jpg'],
            ],
            [
                'user_id'     => $contributors[3]->id,
                'category_id' => $umkm->id,
                'regency_id'  => $sampang->id,
                'title'       => 'Keripik Singkong Bu Rini Sampang',
                'slug'        => 'keripik-singkong-bu-rini-sampang',
                'description' => 'Keripik Singkong Bu Rini adalah UMKM olahan makanan ringan yang sudah menjadi oleh-oleh khas Sampang. Diproduksi dari singkong pilihan yang diiris tipis dan digoreng renyah dengan berbagai varian rasa: original, balado, keju, dan jagung bakar. Proses produksi melibatkan ibu-ibu PKK setempat, memberdayakan ekonomi rumah tangga di lingkungan sekitar.',
                'address'     => 'Jl. Raya Sampang-Pamekasan KM 3, Sampang',
                'maps_url'    => 'https://maps.google.com/?q=Sampang+Madura',
                'open_time'   => '07:00:00',
                'close_time'  => '17:00:00',
                'view_count'  => 2900,
                'photos'      => ['images/food.png', 'images/culture/culture05.jpg'],
            ],
        ];

        // === SPOT FOTO ===
        $spotFotoList = [
            [
                'user_id'     => $contributors[0]->id,
                'category_id' => $spotFoto->id,
                'regency_id'  => $bangkalan->id,
                'title'       => 'Bukit Geger Bangkalan',
                'slug'        => 'bukit-geger-bangkalan',
                'description' => 'Bukit Geger menawarkan panorama perbukitan hijau yang menghadap langsung ke Selat Madura dengan pemandangan Jembatan Suramadu di kejauhan. Spot favorit untuk fotografi golden hour dan pre-wedding. Akses jalan menuju bukit sudah diaspal dengan baik dan tersedia area parkir. Di sekitar bukit terdapat padang rumput luas yang sering digunakan untuk piknik dan camping.',
                'address'     => 'Desa Geger, Kecamatan Geger, Bangkalan',
                'maps_url'    => 'https://maps.google.com/?q=Bukit+Geger+Bangkalan',
                'open_time'   => '06:00:00',
                'close_time'  => '18:00:00',
                'view_count'  => 8700,
                'photos'      => ['images/culture/culture04.jpg', 'images/pantai.png'],
            ],
            [
                'user_id'     => $contributors[1]->id,
                'category_id' => $spotFoto->id,
                'regency_id'  => $sampang->id,
                'title'       => 'Gua Lebar Sampang',
                'slug'        => 'gua-lebar-sampang',
                'description' => 'Gua Lebar adalah formasi batu kapur alami yang membentuk gerbang raksasa di Sampang. Cahaya matahari yang menembus celah-celah batu menciptakan efek pencahayaan dramatis yang sangat fotogenik. Lokasi ini menjadi spot favorit fotografer landscape dan pecinta alam. Terdapat kolam air jernih di bawah gua yang menambah keindahan visual.',
                'address'     => 'Desa Batu Karang, Kecamatan Kedungdung, Sampang',
                'maps_url'    => 'https://maps.google.com/?q=Gua+Lebar+Sampang',
                'open_time'   => '07:00:00',
                'close_time'  => '17:00:00',
                'view_count'  => 6100,
                'photos'      => ['images/culture/culture03.jpg', 'images/culture/culture02.jpg'],
            ],
            [
                'user_id'     => $contributors[2]->id,
                'category_id' => $spotFoto->id,
                'regency_id'  => $pamekasan->id,
                'title'       => 'Pantai Batu Kerbuy Pamekasan',
                'slug'        => 'pantai-batu-kerbuy-pamekasan',
                'description' => 'Pantai Batu Kerbuy menyuguhkan formasi batu karang eksotis yang tersebar di sepanjang garis pantai. Saat air surut, formasi batu-batu besar menciptakan kolam-kolam alami yang instagramable. Spot terbaik untuk fotografi saat golden hour dengan latar belakang matahari terbenam di balik bebatuan. Pantai ini masih relatif sepi sehingga sangat nyaman untuk sesi foto tanpa keramaian.',
                'address'     => 'Desa Batu Kerbuy, Kecamatan Pasean, Pamekasan',
                'maps_url'    => 'https://maps.google.com/?q=Pantai+Batu+Kerbuy',
                'open_time'   => '06:00:00',
                'close_time'  => '18:00:00',
                'view_count'  => 5300,
                'photos'      => ['images/pantai.png', 'images/culture/culture08.jpg'],
            ],
            [
                'user_id'     => $contributors[3]->id,
                'category_id' => $spotFoto->id,
                'regency_id'  => $sumenep->id,
                'title'       => 'Gili Labak Sumenep',
                'slug'        => 'gili-labak-sumenep',
                'description' => 'Gili Labak adalah pulau kecil tak berpenghuni di lepas pantai Sumenep dengan air laut paling jernih di Madura. Terumbu karang yang masih alami terlihat jelas dari permukaan air. Pulau ini menjadi surga bagi fotografer underwater dan landscape. Akses menggunakan perahu nelayan dari Pelabuhan Kalianget dengan waktu tempuh sekitar 2 jam. Sangat direkomendasikan untuk snorkeling dan camping.',
                'address'     => 'Pulau Gili Labak, Kabupaten Sumenep',
                'maps_url'    => 'https://maps.google.com/?q=Gili+Labak+Sumenep',
                'open_time'   => '00:00:00',
                'close_time'  => '23:59:59',
                'view_count'  => 15200,
                'photos'      => ['images/pantai.png', 'images/culture/culture06.jpg'],
            ],
        ];

        // Seed all content
        $allContent = array_merge($kulinerList, $umkmList, $spotFotoList);

        foreach ($allContent as $item) {
            $photos = $item['photos'];
            unset($item['photos']);

            $content = Content::updateOrCreate(
                ['slug' => $item['slug']],
                array_merge($item, [
                    'status'       => 'approved',
                    'was_approved' => true,
                ])
            );

            // Clear old photos for this content
            Photo::where('content_id', $content->id)->delete();

            // Seed photos
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
