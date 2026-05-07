<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek apakah tipe_akun sesuai
        if (auth()->user()->tipe_akun !== $role) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}