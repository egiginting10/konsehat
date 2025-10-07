<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah sudah login
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil role user
        $userRole = Auth::user()->role;

        // Cek apakah role user termasuk dalam daftar role yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Kalau role tidak sesuai
        return abort(403, 'Anda tidak memiliki akses.');
    }
}
