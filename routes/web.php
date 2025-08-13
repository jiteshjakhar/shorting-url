<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware('auth')->group(function () {
    //Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:SuperAdmin|Admin')->group(function () {
        Route::get('/invite-admin', [InvitationController::class, 'create'])->name('invite.admin.create');
        Route::post('/invite-admin', [InvitationController::class, 'store'])->name('invite.admin.store');

    });

    Route::middleware('role:Admin|Member')->group(function () {
        //route for generate short url
        Route::get('/short-urls/create', [ShortUrlController::class, 'create'])->name('short-urls.create');
        Route::post('/short-urls', [ShortUrlController::class, 'store'])->name('short-urls.store');
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
