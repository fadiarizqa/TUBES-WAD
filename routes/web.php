<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FoundedItemController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\UserController;


Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});


Route::middleware('auth')->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/lost_items', [LostItemController::class, 'index'])->name('lost_items.index');
    Route::get('/lost_items/create', [LostItemController::class, 'create'])->name('lost_items.create');
    Route::post('/lost_items', [LostItemController::class, 'store'])->name('lost_items.store');
    Route::get('/founded_items', [FoundedItemController::class, 'index'])->name('founded_items.index');
    Route::get('/founded_items/create', [FoundedItemController::class, 'create'])->name('founded_items.create');
    Route::post('/founded_items', [FoundedItemController::class, 'store'])->name('founded_items.store');
    Route::get('/founded_items/{id}', [FoundedItemController::class, 'show'])->name('founded_items.show');
    Route::get('/founded_items/{id}/edit', [FoundedItemController::class, 'edit'])->name('founded_items.edit');
    Route::put('/founded_items/{id}', [FoundedItemController::class, 'update'])->name('founded_items.update');
    Route::delete('/founded_items/{id}', [FoundedItemController::class, 'destroy'])->name('founded_items.destroy');
    Route::get('/lost_items/{id}', [LostItemController::class, 'show'])->name('lost_items.show');
    Route::get('/lost_items/{id}/edit', [LostItemController::class, 'edit'])->name('lost_items.edit');
    Route::put('/lost_items/{id}', [LostItemController::class, 'update'])->name('lost_items.update');
    Route::delete('/lost_items/{id}', [LostItemController::class, 'destroy'])->name('lost_items.destroy');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

});