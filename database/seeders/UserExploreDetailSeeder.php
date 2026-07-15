<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;
use App\Models\User;
use App\Models\Category;
use App\Models\Regency;
use App\Models\Photo;

class UserExploreDetailSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user author
        $user = User::first() ?? User::factory()->create();

        // Siapkan Kategori Kuliner
        $category = Category::firstOrCreate(['slug' => 'kuliner'], ['name' => 'Kuliner']);

        // Siapkan Kabupaten Bangkalan
        $regency = Regency::firstOrCreate(['slug' => 'bangkalan'], [
            'name' => 'Bangkalan',
            'img' => 'images/culture/culture01.jpg'
        ]);

        // Hapus dummy lama terkait Bebek Sinjay agar tidak dobel
        Content::where('title', 'Bebek Sinjay Asli Bangkalan')->forceDelete();

        // 1. Konten Utama (Bebek Sinjay Asli Bangkalan)
        $description = <<<EOD
Bebek Sinjay adalah ikon kuliner Madura yang telah melegenda. Berlokasi di Bangkalan, tempat makan ini menjadi destinasi wajib bagi siapa pun yang melintasi Jembatan Suramadu. Keistimewaan Bebek Sinjay terletak pada daging bebeknya yang digoreng garing di luar namun tetap lembut dan *juicy* di dalam, berkat bumbu rempah rahasia yang meresap sempurna.

Namun, bintang utama yang membuat Bebek Sinjay tak terlupakan adalah **Sambal Pencit** (sambal mangga muda). Perpaduan rasa pedas yang nendang, gurih, dan asam segar dari mangga muda menciptakan harmoni rasa yang luar biasa saat disantap bersama nasi hangat dan bebek goreng.

Tempat makannya sangat luas dan selalu ramai, terutama saat jam makan siang dan akhir pekan. Sistem pemesanannya cukup efisien meskipun antrean panjang sering terjadi. Pastikan untuk datang lebih awal jika tidak ingin kehabisan, karena porsi yang disediakan setiap harinya seringkali ludes terjual sebelum sore hari.
EOD;

        $mainContent = Content::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'regency_id' => $regency->id,
            'title' => 'Bebek Sinjay Asli Bangkalan',
            'slug' => 'bebek-sinjay-asli-bangkalan',
            'description' => $description,
            'address' => 'Jl. Raya Ketengan No.45, Tunjung, Kec. Burneh, Kabupaten Bangkalan',
            'maps_url' => 'https://maps.google.com/?q=-7.050,112.750',
            'status' => 'approved',
            'was_approved' => true,
            'view_count' => 12500
        ]);

        // Dummy Photos for Bebek Sinjay
        Photo::create(['content_id' => $mainContent->id, 'file_path' => 'images/culture/culture01.jpg', 'is_primary' => true]);
        Photo::create(['content_id' => $mainContent->id, 'file_path' => 'images/culture/culture02.jpg', 'is_primary' => false]);
        Photo::create(['content_id' => $mainContent->id, 'file_path' => 'images/culture/culture03.jpg', 'is_primary' => false]);
        Photo::create(['content_id' => $mainContent->id, 'file_path' => 'images/culture/culture04.jpg', 'is_primary' => false]);
        Photo::create(['content_id' => $mainContent->id, 'file_path' => 'images/culture/culture05.jpg', 'is_primary' => false]);

        // 2. Konten Terkait (Sate Madura H. Toha)
        $related1 = Content::updateOrCreate(
            ['slug' => 'sate-madura-h-toha'],
            [
                'user_id' => $user->id,
                'category_id' => $category->id,
                'regency_id' => $regency->id,
                'title' => 'Sate Madura H. Toha',
                'description' => 'Sate khas Madura dengan bumbu kacang legendaris dan daging yang empuk, cocok didampingi dengan lontong hangat.',
                'address' => 'Bangkalan',
                'maps_url' => 'https://maps.google.com/?q=',
                'status' => 'approved',
                'was_approved' => true,
                'view_count' => 3120
            ]
        );
        Photo::firstOrCreate(['content_id' => $related1->id, 'is_primary' => true], ['file_path' => 'images/culture/culture05.jpg']);

        // 3. Konten Terkait (Soto Mata Sapi Burneh)
        $related2 = Content::updateOrCreate(
            ['slug' => 'soto-mata-sapi-burneh'],
            [
                'user_id' => $user->id,
                'category_id' => $category->id,
                'regency_id' => $regency->id,
                'title' => 'Soto Mata Sapi Burneh',
                'description' => 'Soto khas dari daerah Burneh dengan cita rasa rempah kuat dan daging mata sapi yang diolah khusus hingga sangat lembut.',
                'address' => 'Bangkalan',
                'maps_url' => 'https://maps.google.com/?q=',
                'status' => 'approved',
                'was_approved' => true,
                'view_count' => 1950
            ]
        );
        Photo::firstOrCreate(['content_id' => $related2->id, 'is_primary' => true], ['file_path' => 'images/culture/culture06.jpg']);

        // 4. Konten Terkait (Nasi Serpah Khas Bangkalan)
        $related3 = Content::updateOrCreate(
            ['slug' => 'nasi-serpah-khas-bangkalan'],
            [
                'user_id' => $user->id,
                'category_id' => $category->id,
                'regency_id' => $regency->id,
                'title' => 'Nasi Serpah Khas Bangkalan',
                'description' => 'Sajian nasi dengan kuah bumbu merah kental yang menggugah selera, dilengkapi dengan aneka lauk seperti empal dan usus.',
                'address' => 'Bangkalan',
                'maps_url' => 'https://maps.google.com/?q=',
                'status' => 'approved',
                'was_approved' => true,
                'view_count' => 4500
            ]
        );
        Photo::firstOrCreate(['content_id' => $related3->id, 'is_primary' => true], ['file_path' => 'images/culture/culture07.jpg']);

        // 5. Konten Terkait (Topak Ladeh Bangkalan)
        $related4 = Content::updateOrCreate(
            ['slug' => 'topak-ladeh-bangkalan'],
            [
                'user_id' => $user->id,
                'category_id' => $category->id,
                'regency_id' => $regency->id,
                'title' => 'Topak Ladeh Bangkalan',
                'description' => 'Hidangan spesial hari raya yang menggunakan topak (ketupat) dan ladeh, bumbu halus kaya rempah dengan campuran santan kental yang dimasak perlahan.',
                'address' => 'Bangkalan',
                'maps_url' => 'https://maps.google.com/?q=',
                'status' => 'approved',
                'was_approved' => true,
                'view_count' => 880
            ]
        );
        Photo::firstOrCreate(['content_id' => $related4->id, 'is_primary' => true], ['file_path' => 'images/culture/culture01.jpg']);
    }
}
