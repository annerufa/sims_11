<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function home()
    {
        switch (session('jabatan')) {
            case 'admin':
                return redirect('/admin');
            case 'ks':
                return redirect('/kepala');
            default:
                return redirect('/');
        }
    }

    public function login()
    {
        session()->forget('errorLogin');
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        if (Auth::attempt($request->only('no_pegawai', 'password'))) {
            $request->session()->regenerate();
            // Simpan di session saat login
            Session(['jabatan' => Auth::user()->jabatan]);

            switch (session('jabatan')) {
                case 'admin':
                    return redirect('/admin');
                case 'ks':
                    return redirect('/kepala');
                default:
                    return redirect('/welcome');
            }
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

        if ($user->jabatan == "admin") {
            return redirect('/admin');
        } else if ($user->jabatan == "ks") {
            return redirect('/kepala');
        }

        return back()->withErrors([
            'no_pegawai' => 'No Pegawai tidak valid.',
        ]);
    }
}
