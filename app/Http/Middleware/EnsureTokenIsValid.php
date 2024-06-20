<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user) {
            $token = $user->currentAccessToken();
            Log::info('Current token', ['token' => $token]);

            // Pastikan token adalah instance dari PersonalAccessToken
            if ($token instanceof PersonalAccessToken) {
                // Ambil konfigurasi waktu expire token
                $expirationMinutes = config('sanctum.expiration');
                Log::info('Token expiration minutes', ['expiration' => $expirationMinutes]);

                // Hitung selisih waktu dengan saat ini
                $diffInMinutes = Carbon::parse($token->created_at)->diffInMinutes(now());
                Log::info('Token age in minutes', ['age' => $diffInMinutes]);

                // Jika melewati waktu expire, hapus token
                if ($diffInMinutes > $expirationMinutes) {
                    $token->delete();
                    Log::info('Token expired and deleted');
                    return response()->json(['message' => 'Token has expired'], 401);
                }
            }
        }

        return $next($request);
    }
}
