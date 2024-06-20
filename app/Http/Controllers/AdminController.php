<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bill;
use App\Models\JadwalSampah;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function editSchedule(Request $request)
    {
        $validatedData = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'hari' => 'required|string|max:255',
            'waktu' => 'required|string|max:255',
        ]);

        $schedule = JadwalSampah::find($validatedData['schedule_id']);
        $schedule->hari = $validatedData['hari'];
        $schedule->waktu = $validatedData['waktu'];
        $schedule->save();

        return response()->json($schedule, 200);
    }

    public function getBills(Request $request)
    {
        $bills = Bill::all();
        return response()->json($bills, 200);
    }

    public function addBill(Request $request)
    {
        $validatedData = $request->validate([
            'no_kav' => 'required|exists:users,nomor_kavling',
            'nama' => 'required|string|max:255',
            'thn_bl' => 'required|string|max:6',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric',
        ]);

        $bill = new Bill();
        $bill->no_kav = $validatedData['no_kav'];
        $bill->nama = $validatedData['nama'];
        $bill->thn_bl = $validatedData['thn_bl'];
        $bill->meter_awal = $validatedData['meter_awal'];
        $bill->meter_akhir = $validatedData['meter_akhir'];
        $bill->penggunaan_air = $bill->meter_akhir - $bill->meter_awal;
        $bill->tag_air = 4500 * $bill->penggunaan_air;
        $bill->adm_air = 12500;
        $bill->admin = 2500;
        $bill->tag_now = $bill->ipl + $bill->tag_air + $bill->adm_air + $bill->admin;
        $bill->total_tag = $bill->tag_now + $bill->tunggakan_1 + $bill->tunggakan_2 + $bill->tunggakan_3;
        $bill->save();

        return response()->json($bill, 201);
    }

    public function updateBill(Request $request)
    {
        $validatedData = $request->validate([
            'bill_id' => 'required|exists:bills,id',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric',
        ]);

        $bill = Bill::find($validatedData['bill_id']);
        $bill->meter_awal = $validatedData['meter_awal'];
        $bill->meter_akhir = $validatedData['meter_akhir'];
        $bill->penggunaan_air = $bill->meter_akhir - $bill->meter_awal;
        $bill->tag_air = 4500 * $bill->penggunaan_air;
        $bill->adm_air = 12500;
        $bill->admin = 2500;
        $bill->tag_now = $bill->ipl + $bill->tag_air + $bill->adm_air + $bill->admin;
        $bill->total_tag = $bill->tag_now + $bill->tunggakan_1 + $bill->tunggakan_2 + $bill->tunggakan_3;
        $bill->save();

        return response()->json($bill, 200);
    }

    public function getBillHistory(Request $request)
    {
        $bills = Bill::where('no_kav', $request->no_kav)->get();
        return response()->json($bills, 200);
    }

    public function getUsers(Request $request)
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function addUser(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nomor_kavling' => 'required|string|max:255',
            'blok_cluster' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'id_pelanggan_online' => 'required|string|max:255|unique:users',
            'nomor_rumah' => 'required|string|max:255',
        ]);

        $user = new User();
        $user->nama = $validatedData['nama'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->nomor_kavling = $validatedData['nomor_kavling'];
        $user->blok_cluster = $validatedData['blok_cluster'];
        $user->no_hp = $validatedData['no_hp'];
        $user->id_pelanggan_online = $validatedData['id_pelanggan_online'];
        $user->nomor_rumah = $validatedData['nomor_rumah'];
        $user->save();

        return response()->json($user, 201);
    }
    public function getDashboardData(Request $request)
    {
        // Logika untuk mengambil data dashboard admin
        $schedule = JadwalSampah::latest()->first(); // Contoh: mengambil jadwal terbaru
        $bill = Bill::latest()->first(); // Contoh: mengambil tagihan terbaru

        return response()->json([
            'schedule_title' => $schedule ? $schedule->hari . ', ' . $schedule->waktu : 'Tidak ada jadwal',
            'meter_awal' => $bill ? $bill->meter_awal : 'N/A',
            'meter_akhir' => $bill ? $bill->meter_akhir : 'N/A',
            'meter_tagihan' => $bill ? ($bill->meter_akhir - $bill->meter_awal) : 'N/A'
        ], 200);
    }
    public function getAdminData()
    {
        $user = Auth::user();
        return response()->json([
            'nama' => $user->nama,
            'nomor_rumah' => $user->nomor_rumah,
            'tanggal' => now()->format('l, d F Y'),
        ], 200);
    }
}