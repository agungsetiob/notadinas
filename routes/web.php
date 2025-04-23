<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotaDinasController;
use App\Http\Controllers\NotaPengirimanController;
use App\Http\Controllers\NotaPersetujuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SkpdController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/nota-dinas/{nota}/kirim', [NotaPengirimanController::class, 'store'])->name('nota.pengiriman.store');
    Route::get('/nota/lampiran/{tipe}/{id}', [NotaDinasController::class, 'getLampiranHistori']);
    Route::resource('nota-dinas', NotaDinasController::class);
    Route::get('/nota/{id}/histori-pengiriman', [NotaPengirimanController::class, 'history'])->name('nota.pengiriman.history');
    Route::get('/nota/lampiran/{id}', [NotaDinasController::class, 'getLampiran']);
    Route::get('api/histori-persetujuan/{id}', [NotaPersetujuanController::class, 'approvalHistories']);
    Route::get('/approval-histories', [NotaPersetujuanController::class, 'index'])->name('approval-histories.index');
});

Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users', [RegisteredUserController::class, 'index'])->name('users.index');
        Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('/register', [RegisteredUserController::class, 'store']);
        Route::patch('/users/{user}/status', [RegisteredUserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::resource('skpds', SkpdController::class);
        Route::patch('skpds/{skpd}/toggle-status', [SkpdController::class, 'toggleStatus'])->name('skpds.toggle-status');
    });
    
    Route::middleware(['auth', 'role:bupati'])->group(function () {
        Route::patch('/nota-dinas/{nota}/approve', [NotaDinasController::class, 'approveOrRejectNota'])->name('nota-dinas.approval');
    });
    
});

Route::middleware(['auth', 'role:skpd,asisten,sekda,bupati'])->group(function () {
    Route::post('/nota-dinas/{nota}/kembalikan', [NotaPengirimanController::class, 'returnNota'])->name('nota.kembalikan');
    //Route::resource('nota-dinas', NotaDinasController::class);
    //Route::get('/nota/{id}/histori-pengiriman', [NotaPengirimanController::class, 'history'])->name('nota.pengiriman.history');
});




require __DIR__.'/auth.php';
