<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles  // Parameter ini akan menangkap semua role ('admin', 'editor', dst.)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan pengguna sudah login
        if (! $request->user()) {
            // Jika tidak ada user, biarkan middleware 'auth' yang menanganinya atau redirect
            return redirect('login');
        }

        // 2. Loop melalui role yang diizinkan dari route
        foreach ($roles as $role) {
            // 3. Cek apakah user memiliki role tersebut
            //    Asumsi: Model User Anda punya method `hasRole()` atau kolom `role`.
            //    Gantilah 'role' dengan nama kolom yang benar di tabel users Anda.
            if ($request->user()->role == $role) {
                // Jika role cocok, izinkan request untuk melanjutkan
                return $next($request);
            }
        }

        // 4. Jika setelah di-loop tidak ada role yang cocok, tolak akses.
        abort(403, 'UNAUTHORIZED ACTION.');
    }
}