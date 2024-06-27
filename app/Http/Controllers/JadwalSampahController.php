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

    public function addSchedule(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'hari' => 'required|string',
            'waktu' => 'required|string',
        ]);

        $schedule = new JadwalSampah();
        $schedule->hari = $validatedData['hari'];
        $schedule->waktu = $validatedData['waktu'];
        $schedule->save();

        return response()->json(['message' => 'Schedule added successfully'], 201);
    }

    public function deleteScheduleByDay(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'hari' => 'required|string',
        ]);

        $schedules = JadwalSampah::where('hari', $validatedData['hari'])->get();

        if ($schedules->isEmpty()) {
            return response()->json(['message' => 'No schedules found for the specified day'], 404);
        }

        foreach ($schedules as $schedule) {
            $schedule->delete();
        }

        return response()->json(['message' => 'Schedules deleted successfully'], 200);
    }


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
