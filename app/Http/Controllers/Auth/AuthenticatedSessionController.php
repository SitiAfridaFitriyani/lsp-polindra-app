<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::firstWhere('email', $request->email);
        $password = $request->password;
        if($user) {
            $passwordCheck = Hash::check($password, $user['password']);
            if($passwordCheck && $user->role == 'Asesi' && $user->asesi['status'] === 'nonactive') {
                return back()->with('status_account','Akun assesmen anda belum di aktifkan, silahkan hubungi admin');
            } elseif ($passwordCheck && $user['status'] === 'nonactive') {
                return back()->with('status_account','Akun anda telah di nonaktifkan');
            }
        } else {
            return back()->with('status_account','Username/Password salah');
        }
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
