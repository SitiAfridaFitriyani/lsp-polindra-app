<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Asesi;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required','regex:/(08)[0-9]{9}/', 'unique:'.User::class],
            'nim' => ['required','numeric', 'unique:'.Asesi::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        DB::beginTransaction();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $asesi = Asesi::create([
            'user_id' => $user['id'],
            'nim' => $request->nim,
            'kelas_id' => $request->kelas_id
        ]);

        if(!$user || !$asesi) {
            DB::rollBack();
            return back()->with('error','Terjadi kesalahan dalam mendaftar, silahkan coba lagi!');
        }

        // event(new Registered($user));
        // Auth::login($user);
        DB::commit();
        return back()->with('success','Selamat, Kamu berhasil mendaftar. Selanjutnya akunmu akan ditinjau oleh admin untuk dilakukan verifikasi.');
    }
}
