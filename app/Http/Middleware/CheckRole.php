<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Log header authorization
        Log::info('Authorization Header: ' . $request->header('Authorization'));

        if ($request->bearerToken()) {
            $token = $request->bearerToken();
            Log::info('Current token: ' . $token);
        } else {
            Log::info('No token found');
        }

        if (Auth::check()) {
            $user = Auth::user();
            Log::info('User role: ' . $user->role);
            if ($user->role === $role) {
                return $next($request);
            } else {
                Log::info('Role mismatch: Required role: ' . $role . ', User role: ' . $user->role);
            }
        } else {
            Log::info('User not authenticated');
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return redirect('/login')->with('error', 'You do not have access to this page.');
    }
}
