<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login dan role-nya admin
        if (!Auth::check() || Auth::user()->role !== User::ROLE_ADMIN) {
            abort(403, 'Admin only.');
        }

        return $next($request);
    }
}
