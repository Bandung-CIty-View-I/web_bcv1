<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    public function getBills(Request $request)
    {
        $user = Auth::user();

        $query = Bill::with('user');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        if ($request->has('year')) {
            $query->whereYear('thn_bl', $request->year);
        }
        if ($request->has('month')) {
            $query->whereMonth('thn_bl', $request->month);
        }

        if ($request->has('name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->name . '%');
            });
        }

        $bills = $query->get();

        return response()->json($bills, 200);
    }

    public function addBill(Request $request)
    {

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'paid' => 'required|boolean',
            'thn_bl' => 'required|string|size:6',
            'ipl' => 'required|integer',
            'meter_awal' => 'required|integer',
            'meter_akhir' => 'required|integer',
            'tunggakan_1' => 'integer|nullable',
            'tunggakan_2' => 'integer|nullable',
            'tunggakan_3' => 'integer|nullable',
        ]);

        $user = User::find($data['user_id']);

        $billData = Bill::calculateBill(
            $data['meter_awal'],
            $data['meter_akhir'],
            $data['ipl'],
            $data['tunggakan_1'] ?? 0,
            $data['tunggakan_2'] ?? 0,
            $data['tunggakan_3'] ?? 0
        );

        $bill = Bill::where('user_id', $data['user_id'])
                    ->where('thn_bl', $data['thn_bl'])
                    ->first();

        if ($bill) {
            $bill->update(array_merge($data, $billData));
            return response()->json($bill, 200);
        } else {

            $bill = Bill::create(array_merge($data, $billData));
            return response()->json($bill, 201);
        }
    }
}
