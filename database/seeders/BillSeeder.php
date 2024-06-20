<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bill;
use App\Models\User;

class BillSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $meter_awal = rand(100, 500);
            $meter_akhir = rand(500, 1000);
            $ipl = 50000;
            $tunggakan_1 = 0;
            $tunggakan_2 = 0;
            $tunggakan_3 = 0;

            $billData = Bill::calculateBill($meter_awal, $meter_akhir, $ipl, $tunggakan_1, $tunggakan_2, $tunggakan_3);

            Bill::create([
                'user_id' => $user->id,
                'paid' => rand(0, 1),
                'thn_bl' => now()->format('Ym'),
                'ipl' => $ipl,
                'meter_awal' => $meter_awal,
                'meter_akhir' => $meter_akhir,
                'penggunaan_air' => $billData['penggunaan_air'],
                'tag_air' => $billData['tag_air'],
                'adm_air' => $billData['adm_air'],
                'admin' => $billData['admin'],
                'tunggakan_1' => $tunggakan_1,
                'tunggakan_2' => $tunggakan_2,
                'tunggakan_3' => $tunggakan_3,
                'tag_now' => $billData['tag_now'],
                'total_tag' => $billData['total_tag'],
            ]);
        }
    }
}
