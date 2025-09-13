<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $response = $next($request);

        // Update last login time for authenticated users
        if (Auth::check()) {
            $user = Auth::user();

            // Only update if it's been more than 5 minutes since last update
            // This prevents excessive database updates on every request
            if (!$user->last_login_at || $user->last_login_at->diffInMinutes(now()) >= 5) {
                DB::table('users')->where('id', $user->id)->update(['last_login_at' => now()]);
            }
        }

        return $response;
    }
}
