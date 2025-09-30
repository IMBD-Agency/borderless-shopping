<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role = null): Response {
        if (Auth::check()) {
            $user = Auth::user();

            // If no specific role is required, check if user has admin privileges
            if ($role === null) {
                if (!$user->hasAdminPrivileges()) {
                    return redirect()->route('user.dashboard')->withErrors([
                        'access_denied' => 'You do not have permission to access this area.'
                    ]);
                }
            } else {
                // Check for specific role
                if ($user->role !== $role) {
                    return redirect()->route('user.dashboard')->withErrors([
                        'access_denied' => 'You do not have permission to access this area.'
                    ]);
                }
            }
        }

        return $next($request);
    }
}
