<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): \Illuminate\View\View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginInput = $request->login;
        $password = $request->password;

        // Try authenticate with Siswa model FIRST - try both NIS and email
        $siswa = \App\Models\Siswa::where('nis', $loginInput)
            ->orWhere('email', $loginInput)
            ->first();

        if ($siswa && \Illuminate\Support\Facades\Hash::check($password, $siswa->password)) {
            Auth::login($siswa);
            $request->session()->regenerate();
            // Store the model type to help with ID collision resolution
            $request->session()->put('auth_model_type', 'siswa');
            return redirect()->intended('/siswa/dashboard');
        }

        // Try authenticate with User model (Admin/Guru) only with email
        $user = \App\Models\User::where('email', $loginInput)->first();
        if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            // Store the model type to help with ID collision resolution
            $request->session()->put('auth_model_type', 'user');

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            if ($user->role === 'guru_bk') {
                return redirect()->intended('/guru/dashboard');
            }
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'login' => __('auth.failed'),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->forget('auth_model_type');
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
