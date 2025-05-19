
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckJabatan;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\ProfilController;

// Route  ->middleware([CheckJabatan::class . ':adminSM,ks']);

Route::resource('surat-masuk', SuratMasukController::class)->middleware('auth');
Route::resource('surat-keluar', SuratKeluarController::class)->middleware('auth');
Route::resource('disposisi', DisposisiController::class)->middleware('auth');
Route::resource('agenda', AgendaController::class)->middleware('auth');
Route::resource('instansi', InstansiController::class)->middleware('auth');
Route::resource('profil', ProfilController::class)->middleware('auth');
Route::get('/', function () {
    return view('auth');
});
Route::post('surat_masuk.print', [SuratMasukController::class, 'print'])->name('surat_masuk.print');
Route::post('surat_keluar.print', [SuratKeluarController::class, 'print'])->name('surat_keluar.print');
// register 
Route::get('validasi-surat', [SuratKeluarController::class, 'validasiShow'])->name('validasi-surat');
Route::get('detail.validasi/{id}', [SuratKeluarController::class, 'detailValidasi'])->name('detail.validasi');
Route::get('/setujui/{id}', [SuratKeluarController::class, 'setujui'])->name('setujui');
Route::post('/revisi', [SuratKeluarController::class, 'revisi'])->name('revisi');
Route::post('uploadArsip/{id}', [SuratKeluarController::class, 'uploadArsip'])->name('uploadArsip');
Route::post('revisiDone/{suratKeluar}', [SuratKeluarController::class, 'revisiDone'])->name('revisiDone');
Route::get('/disDone/{id}', [DisposisiController::class, 'disDone'])->name('disDone');
Route::get('/detailWaka/{id}', [DisposisiController::class, 'detailWaka'])->name('detailWaka');
Route::get('/arsipSk/{id}', [SuratKeluarController::class, 'arsipSk'])->name('arsipSk');
// Route::get('/detailWaka/{id}', [DisposisiController::class, 'detailWaka'])->name('detailWaka');

// login & logout
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('actionlogin', [AuthController::class, 'actionlogin'])->name('actionlogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// register
Route::post('/daftarakun', [AuthController::class, 'register'])->name('register');

// dashboard
Route::get('/dashboard', [AuthController::class, 'home'])->name('dashboard');

// test
Route::get('/admin', function () {
    return view('admin');
});
Route::get('/kepala', function () {
    return view('kepala');
});
Route::get('/select', function () {
    return view('surat-masuk.select2');
});
Route::get('/testujuan', [InstansiController::class, 'testujuan']);
Route::get('/access-denied', function () {
    return view('access-denied'); // Buat view ini nanti
})->name('access.denied');

Route::get('/get-instansi', [InstansiController::class, 'getInstansi'])->name('get.instansi');
Route::get('/test-helper', function () {
    // Test is_active_route
    $routeActive = is_active_route('test-helper');

    // Test is_active_url
    $urlActive = is_active_url('test-helper');

    return [
        'route_active' => $routeActive,
        'url_active' => $urlActive
    ];
})->name('test-helper');
