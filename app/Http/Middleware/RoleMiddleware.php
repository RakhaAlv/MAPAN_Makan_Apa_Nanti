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
 
        // Cek apakah role sesuai dengan yang ada di database
        if (auth()->user()->role !== $role) {
            abort(403, 'Akses ditolak. Peran kamu (' . auth()->user()->role . ') tidak memiliki akses ke halaman ini.');
        }
 
        return $next($request);
    }
}