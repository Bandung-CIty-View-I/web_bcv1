<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nomor_kavling' => 'required|string|max:255',
            'blok_cluster' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'id_pelanggan_online' => 'required|string|max:255|unique:users',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']); 

        $user = User::create($validatedData);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'sometimes|required|string|min:8',
            'nomor_kavling' => 'sometimes|required|string|max:255',
            'blok_cluster' => 'sometimes|required|string|max:255',
            'no_hp' => 'sometimes|required|string|max:255',
            'id_pelanggan_online' => 'sometimes|required|string|max:255|unique:users,id_pelanggan_online,'.$id,
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']); 
        }

        $user->update($validatedData);

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
    public function registerWarga(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'blok_cluster' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nomor_kavling' => 'required|string|max:255',
            'id_pelanggan_online' => 'required|string|max:255|unique:users', 
        ]);
    
        $user = User::create([
            'nama' => $validatedData['nama'],
            'blok_cluster' => $validatedData['blok_cluster'],
            'no_hp' => $validatedData['no_hp'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'warga',
            'nomor_kavling' => $validatedData['nomor_kavling'], 
            'id_pelanggan_online' => $validatedData['id_pelanggan_online'],
        ]);
    
        return response()->json($user, 201);
    }
    public function findName(Request $request)
    {
        $request->validate([
            'nomor_kavling' => 'required|string',
            'blok' => 'required|string',
        ]);
    
        try {
            $user = User::where('nomor_kavling', $request->nomor_kavling)
                        ->where('blok_cluster', $request->blok)
                        ->first();
    
            if ($user) {
                return response()->json(['nama' => $user->nama, 'user_id' => $user->id], 200);
            } else {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error finding user: '.$e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

}
