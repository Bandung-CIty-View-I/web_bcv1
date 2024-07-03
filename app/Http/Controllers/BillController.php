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
        
        if ($data['meter_akhir'] < $data['meter_awal']) {
            return response()->json(['message' => 'Pastikan besaran meter akhir! Meter akhir tidak dapat kurang dari meter awal!'], 400);
        }
        
        $user = User::find($data['user_id']);

        $previousBill = Bill::where('user_id', $data['user_id'])
                            ->orderBy('created_at', 'desc')
                            ->first();

                            if ($previousBill) {
                                $totalTagihanBulanLalu = $previousBill->tag_now;
                                $tunggakan_1 = $previousBill->tunggakan_1;
                                $tunggakan_2 = $previousBill->tunggakan_2;
                                $tunggakan_3 = $previousBill->tunggakan_3;
                                $lastMonthPaid = $previousBill->paid; 
                            
                                if ($lastMonthPaid == 0) {
                                    if ($tunggakan_1 != null) {
                                        if ($tunggakan_2 != null) {
                                            $data['tunggakan_3'] = $tunggakan_3 + $tunggakan_2;
                                            $data['tunggakan_2'] = $tunggakan_1;
                                            $data['tunggakan_1'] = $totalTagihanBulanLalu;
                                        } else {
                                            $data['tunggakan_2'] = $tunggakan_1;
                                            $data['tunggakan_1'] = $totalTagihanBulanLalu;
                                        }
                                    } else {
                                        $data['tunggakan_1'] = $totalTagihanBulanLalu;
                                    }
                                } else {
                                    $data['tunggakan_1'] = 0;
                                    $data['tunggakan_2'] = 0;
                                    $data['tunggakan_3'] = 0;
                                }
                            }                            

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

    public function getMeterAwal(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            $bill = Bill::where('user_id', $request->user_id)
                        ->orderBy('created_at', 'desc')
                        ->first();

            if ($bill) {
                return response()->json($bill, 200); 
            } else {
                return response()->json(['error' => 'Bill not found'], 404); 
            }
        } catch (\Exception $e) {
            Log::error('Error fetching meter awal: '.$e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function getBillByMonth(Request $request)
    {
        $request->validate([
            'thn_bl' => 'required|string|size:6',
        ]);

        try {
            $user = Auth::user();
            $bill = Bill::where('user_id', $user->id)
                        ->where('thn_bl', $request->thn_bl)
                        ->first();

            if ($bill) {
                return response()->json($bill, 200);
            } else {
                return response()->json(['message' => 'Tagihan tidak ditemukan untuk bulan tersebut'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching bill by month: '.$e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
