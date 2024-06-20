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
            'nama' => 'Admin User',
            'email' => 'admin@example.com',
            // 'nomor_rumah' => '50A',
            'blok_cluster' => 'A',
            'nomor_kavling' => 'A1',
            'no_hp' => '08123456789',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'id_pelanggan_online' => '12345',
        ]);

        User::create([
            'nama' => 'Warga User',
            'email' => 'warga@example.com',
            // 'nomor_rumah' => '179B' ,
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
            // 'nomor_rumah' => '12B' ,
            'blok_cluster' => 'C',
            'nomor_kavling' => 'C2',
            'no_hp' => '081234542780',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'id_pelanggan_online' => '14346',
        ]);
    }
}
