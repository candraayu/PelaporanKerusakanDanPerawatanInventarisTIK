<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id_kecamatan' => null,
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'id_kecamatan' => null,
            'nama' => 'Kabid',
            'email' => 'kabid@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'kabid'
        ]);
    }
}
