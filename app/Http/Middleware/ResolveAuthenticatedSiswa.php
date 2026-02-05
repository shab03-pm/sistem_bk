<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveAuthenticatedSiswa
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is authenticated but is actually a Siswa model
        if (auth()->check()) {
            $user = auth()->user();

            // If this is a Siswa (has role siswa and table is siswas)
            if ($user instanceof \App\Models\Siswa) {
                // User is already Siswa, keep as is and store model type
                $request->session()->put('auth_model_type', 'siswa');
                return $next($request);
            }

            // If user has role siswa but is from User model, try to find in Siswa
            if ($user->role === 'siswa') {
                // Check if this should be a Siswa instead
                $siswa = \App\Models\Siswa::where('email', $user->email)
                    ->orWhere('nis', $user->nis ?? '')
                    ->first();

                if ($siswa) {
                    // Re-login as Siswa
                    auth()->guard('web')->logout();
                    auth()->guard('web')->login($siswa);
                    $request->session()->put('auth_model_type', 'siswa');
                }
            } else {
                // User is from User model (admin/guru)
                $request->session()->put('auth_model_type', 'user');
            }
        }

        return $next($request);
    }
}
