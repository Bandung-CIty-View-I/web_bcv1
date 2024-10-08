<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = Auth::user();
        $user->tanggal = now()->format('l, d F Y');
        return response()->json($user, 200);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'no_hp' => 'sometimes|required|string|max:255',
        ]);

        $user->update($validatedData);

        return response()->json($user, 200);
    }
}
