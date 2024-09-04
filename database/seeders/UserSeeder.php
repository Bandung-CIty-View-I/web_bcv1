<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama' => 'Admin',
            'email' => 'admin@example.com',
            'blok_cluster' => 'A',
            'nomor_kavling' => 'A1',
            'no_hp' => '08123456789',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'id_pelanggan_online' => '12345',
        ]);

        User::create([
            'nama' => 'Warga',
            'email' => 'warga@example.com',
            'blok_cluster' => 'B',
            'nomor_kavling' => 'B2',
            'no_hp' => '08123456780',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'id_pelanggan_online' => '12346',
        ]);

        User::create([
            'nama' => 'Rakyat',
            'email' => 'rakyat@example.com',
            'blok_cluster' => 'C',
            'nomor_kavling' => 'C2',
            'no_hp' => '081234542780',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'id_pelanggan_online' => '14346',
        ]);
    }
}
