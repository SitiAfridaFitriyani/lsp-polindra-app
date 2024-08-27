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
use Mews\Captcha\Facades\Captcha;

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
        $credential = $request->input('credential'); // Input yang bisa berupa email, NIM, NIP, atau username
        $password = $request->password;
        
        if (!Captcha::check($request->captcha)) {
            return back()->with('failed-captcha', 'Kode Captcha tidak sesuai');
        }

        // Cari user berdasarkan credential yang dimasukkan
        $user = User::where('email', $credential)
            ->orWhere('username', $credential)
            ->orWhereHas('asesi', function ($query) use ($credential) {
                $query->where('nim', $credential);
            })
            ->orWhereHas('asesor', function ($query) use ($credential) {
                $query->where('nip', $credential);
            })
            ->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return back()->with('status_account', 'Email/NIM/NIP/Username atau Password salah');
        }

        // Cek status akun
        if ($user->role == 'Asesi' && optional($user)->status === 'nonactive') {
            return back()->with('status_account', 'Akun asesmen anda belum diaktifkan, silahkan hubungi admin');
        } elseif ($user->status === 'nonactive') {
            return back()->with('status_account', 'Akun anda telah dinonaktifkan');
        }

        // Jika semua validasi berhasil, lakukan autentikasi dan regenerasi sesi
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
