
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
// register 
Route::get('validasi-surat', [SuratKeluarController::class, 'validasiShow'])->name('validasi-surat');
Route::get('/setujui/{id}', [SuratKeluarController::class, 'setujui'])->name('setujui');
Route::post('/revisi', [SuratKeluarController::class, 'revisi'])->name('revisi');

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

Route::get('/get-instansi', [InstansiController::class, 'getInstansi'])->name('get.instansi');

// routes/web.php
Route::get('/view-sm-pdf/{filename}', function ($filename) {
    $path = storage_path('app/private/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
    ]);
})->middleware(['auth'])->name('view.private.pdf');
