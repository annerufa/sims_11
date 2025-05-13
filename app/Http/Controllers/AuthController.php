<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function home()
    {
        $sm = SuratMasuk::whereMonth('tanggal_terima', Carbon::now()->month)
            ->whereYear('tanggal_terima', Carbon::now()->year)
            ->count();
        $draft =  SuratKeluar::where('status_validasi', 'draft')
            ->whereMonth('tanggal_srt', Carbon::now()->month)
            ->whereYear('tanggal_srt', Carbon::now()->year)
            ->count();
        $sk = SuratKeluar::whereNot('status_validasi', 'draft')
            ->whereMonth('tanggal_srt', Carbon::now()->month)
            ->whereYear('tanggal_srt', Carbon::now()->year)
            ->count();


        if (Auth::user()) {
            // $jabatan = Auth::user()->jabatan;

            // if ($jabatan === 'ks') {
            //     // $unreadData = SuratMasuk::where('is_read', false)->count();
            //     return view('home', compact('unreadData'));
            // }
            return view('home', compact('sm', 'draft', 'sk'));
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
            session(['nama' => Auth::user()->nama]);
            return redirect('/dashboard');
        }
        return back()->withErrors(['dataLogin' => 'no pegawai atau password salah']);
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
