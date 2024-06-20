<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'paid', 'thn_bl', 'ipl', 'meter_awal', 'meter_akhir',
        'tunggakan_1', 'tunggakan_2', 'tunggakan_3', 'penggunaan_air', 'tag_air', 'adm_air',
        'admin', 'tag_now', 'total_tag'
    ];

    public static function calculateBill($meter_awal, $meter_akhir, $ipl, $tunggakan_1, $tunggakan_2, $tunggakan_3)
    {
        $penggunaan_air = $meter_akhir - $meter_awal;
        $tag_air = 4500 * $penggunaan_air;
        $adm_air = 12500;
        $admin = 2500;
        $tag_now = $ipl + $tag_air + $adm_air + $admin;
        $total_tag = $tag_now + $tunggakan_1 + $tunggakan_2 + $tunggakan_3;

        return [
            'penggunaan_air' => $penggunaan_air,
            'tag_air' => $tag_air,
            'adm_air' => $adm_air,
            'admin' => $admin,
            'tag_now' => $tag_now,
            'total_tag' => $total_tag,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

