<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        $token = $request->bearerToken();
        Log::info('Authorization Header:', [$request->header('Authorization')]);
        Log::info('Token:', [$token]);

        if (!$token) {
            Log::info('No token found');
            return $request->expectsJson() ? null : route('login');
        }

        // Log user role for debugging
        $user = auth()->user();
        Log::info('User role:', [$user ? $user->role : 'Not logged in']);

        return $request->expectsJson() ? null : route('login');
    }
}

