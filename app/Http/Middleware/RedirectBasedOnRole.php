<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Cek jika user sudah login
        if ($user) {
            if ($user->hasRole('admin')) {
                // Jika user adalah admin, arahkan ke dashboard admin
                return redirect()->route('admin.dashboard');
            }
            
            if ($user->hasRole('caterer')) {
                // Jika user adalah caterer, arahkan ke dashboard katering
                return redirect()->route('caterer.dashboard');
            }
            
            if ($user->hasRole('driver')) {
                // Jika user adalah driver, arahkan ke dashboard driver
                return redirect()->route('driver.dashboard');
            }

            if ($user->hasRole('user')) {
                // Jika user adalah customer, arahkan ke halaman makanan
                return redirect()->route('user.dashboard');
            }
        }

        // Jika tidak ada peran yang cocok, lanjutkan saja requestnya
        return $next($request);
    }
}
