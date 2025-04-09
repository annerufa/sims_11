
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckJabatan;

// Route  ->middleware([CheckJabatan::class . ':adminSM,ks']);

Route::get('/', function () {
    return view('auth');
});
// login & logout
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('actionlogin', [AuthController::class, 'actionlogin'])->name('actionlogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// register
Route::post('/daftarakun', [AuthController::class, 'register'])->name('register');

// dashboard
Route::get('/dashboard', [AuthController::class, 'home'])->name('dashboard')
    ->middleware([CheckJabatan::class . ':adminSM, ks']);

// test
Route::get('/admin', function () {
    return view('admin');
});
Route::get('/kepala', function () {
    return view('kepala');
});

Route::get('/access-denied', function () {
    return view('access-denied'); // Buat view ini nanti
})->name('access.denied');
