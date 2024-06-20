<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = Auth::user();
        return response()->json($user, 200);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'nomor_kavling' => 'sometimes|required|string|max:255',
            'blok_cluster' => 'sometimes|required|string|max:255',
            'no_hp' => 'sometimes|required|string|max:255',
            // 'nomor_rumah' => 'sometimes|required|string|max:255',
        ]);

        $user->update($validatedData);

        return response()->json($user, 200);
    }
}
