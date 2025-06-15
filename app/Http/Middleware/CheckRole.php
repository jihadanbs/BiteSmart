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
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah pengguna sudah login DAN memiliki peran yang dibutuhkan
        if (! $request->user() || ! $request->user()->hasRole($role)) {
            // Jika tidak, kirim response 403 (Forbidden)
            abort(403, 'ANDA TIDAK MEMILIKI AKSES!');
        }

        return $next($request);
    }
}
