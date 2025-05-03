<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SuratMasuk;

class AuthController extends Controller
{
    public function home()
    {
        if (Auth::user()) {
            $jabatan = Auth::user()->jabatan;


            if ($jabatan === 'ks') {
                $unreadData = SuratMasuk::where('is_read', false)->count();
                return view('home', compact('unreadData'));
            }
            return view('home');
        }
        return redirect('/');
    }

    public function login()
    {
        session()->forget('errorLogin');
        return view('auth');
    }

    public function actionLogin(Request $request)
    {
        if (Auth::attempt($request->only('no_pegawai', 'password'))) {
            $request->session()->regenerate();
            session(['jabatan' => Auth::user()->jabatan]);
            // Simpan di session saat login

            return redirect('/dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(Request $request)
    {
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_pegawai' => $request->no_pegawai,
            'password' => Hash::make($request->password),
            'jabatan' => $request->jabatan
        ]);

        Auth::login($user);
        // Simpan di session saat login
        session(['jabatan' => Auth::user()->jabatan]);


        if (Auth::check()) {
            // Login berhasil
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'no_pegawai' => 'No Pegawai tidak valid.',
        ]);
    }
}
