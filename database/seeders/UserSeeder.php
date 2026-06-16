<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'       => 'Admin Jelajah',
                'email'      => 'admin@jelajahmadura.test',
                'password'   => Hash::make('password'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Kontributor Test',
                'email'      => 'kontributor@jelajahmadura.test',
                'password'   => Hash::make('password'),
                'role'       => 'contributor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
