<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\DisposisiPenerima;

class NotificationComposer
{
    public function compose(View $view)
    {
        $jabatan = Auth::user()->jabatan;
        if ($jabatan === 'admin') {
            $view->with([
                'suratBaru'   => SuratKeluar::where('status_validasi', 'belum')->count(),
                'unreadData'  => SuratMasuk::where('is_read', false)->count(),
            ]);
        } elseif ($jabatan === 'ks') {
            $view->with([
                'suratBaru'   => SuratKeluar::where('status_validasi', 'belum')->count(),
                'unreadData'  => SuratMasuk::where('is_read', false)->count(),
            ]);
        } else {
            $view->with([
                'draftSurat'   => SuratKeluar::where('status_validasi', 'belum')->count(),
                'unreadData'  => DisposisiPenerima::where('user_id',  Auth::user()->id)->count(),
            ]);
        }
    }
}
