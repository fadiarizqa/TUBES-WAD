<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FoundedItemController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

//Route untuk login ya king:
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

//Kalo ini route untuk register yach:
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/home', function () {
    return 'Berhasil masuk ke /home!';
})->name('home')->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');


//Nah ini route buat posting barang ketemu, founded item maksudnya
Route::get('/founded_items', [FoundedItemController::class, 'index'])->name('founded_items.index');
Route::get('/founded_items/create', [FoundedItemController::class, 'create'])->name('founded_items.create');
Route::post('/founded_items', [FoundedItemController::class, 'store'])->name('founded_items.store');


//Ini middleware nya bos
// Halaman login & register hanya untuk guest
Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Halaman home & logout hanya untuk user yang sudah login
Route::middleware('auth')->group(function() {
    Route::get('/home', function() {
        return view('home');
    })->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
