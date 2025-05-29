<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FoundedItemController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});


Route::middleware('auth')->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    
    Route::get('/founded_items', [FoundedItemController::class, 'index'])->name('founded_items.index');
    Route::get('/founded_items/create', [FoundedItemController::class, 'create'])->name('founded_items.create');
    Route::post('/founded_items', [FoundedItemController::class, 'store'])->name('founded_items.store');
});