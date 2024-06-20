<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalSampah;
use Illuminate\Support\Facades\Auth;

class JadwalSampahController extends Controller
{
    public function getSchedule(Request $request)
    {
        $schedule = JadwalSampah::all(); 
        return response()->json($schedule, 200);
    }

    // public function editSchedule(Request $request)
    // {

    //     if (Auth::user()->role !== 'admin') {
    //         return response()->json(['message' => 'Unauthorized'], 403);
    //     }

    //     $validatedData = $request->validate([
    //         'id' => 'required|integer',
    //         'hari' => 'required|string',
    //         'waktu' => 'required|string',
    //     ]);

    //     $schedule = JadwalSampah::find($validatedData['id']);
    //     if ($schedule) {
    //         $schedule->hari = $validatedData['hari'];
    //         $schedule->waktu = $validatedData['waktu'];
    //         $schedule->save();
    //         return response()->json(['message' => 'Schedule updated successfully'], 200);
    //     } else {
    //         return response()->json(['message' => 'Schedule not found'], 404);
    //     }
    // }
    public function getDashboardData()
    {
        $hariIni = now()->format('l');
    
        $hariIndo = $this->convertToIndonesianDay($hariIni);
    
        $schedule = JadwalSampah::where('hari', $hariIndo)->get();
    
        return response()->json($schedule, 200);
    }
    
    private function convertToIndonesianDay($dayInEnglish)
    {
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
    
        return $days[$dayInEnglish] ?? $dayInEnglish;
    }
    
}
