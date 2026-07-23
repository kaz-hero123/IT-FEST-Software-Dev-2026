<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Admin Jelajah',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        \App\Models\User::firstOrCreate(
            ['email' => 'kontributor@kontributor.com'],
            [
                'name'     => 'Kontributor Test',
                'password' => Hash::make('password'),
                'role'     => 'contributor',
            ]
        );
    }
}
