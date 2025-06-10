<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FoundedItemController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClaimUserController;
use App\Http\Controllers\ClaimResponseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;


Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});


Route::middleware('auth')->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Lost Items
    Route::get('/lost_items', [LostItemController::class, 'index'])->name('lost_items.index');
    Route::get('/lost_items/create', [LostItemController::class, 'create'])->name('lost_items.create');
    Route::post('/lost_items', [LostItemController::class, 'store'])->name('lost_items.store');
    Route::get('/lost_items/{id}/edit', [LostItemController::class, 'edit'])->name('lost_items.edit');
    Route::put('/lost_items/{id}', [LostItemController::class, 'update'])->name('lost_items.update');
    Route::post('/lost_items/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/lost_items/{id}/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/lost_items/{id}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/lost_items/{id}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/lost_items', [LostItemController::class, 'store'])->name('lost_items.store');
    Route::get('/lost_items/{id}', [LostItemController::class, 'show'])->name('lost_items.show');
    Route::delete('/lost_items/{id}', [LostItemController::class, 'destroy'])->name('lost_items.destroy');

    // Founded Items
    Route::get('/founded_items', [FoundedItemController::class, 'index'])->name('founded_items.index');
    Route::get('/founded_items/create', [FoundedItemController::class, 'create'])->name('founded_items.create');
    Route::post('/founded_items', [FoundedItemController::class, 'store'])->name('founded_items.store');
    Route::get('/founded_items/{id}', [FoundedItemController::class, 'show'])->name('founded_items.show');
    Route::post('/founded_items/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/founded_items/{id}/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/founded_items/{id}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/founded_items/{id}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/founded_items/{id}/edit', [FoundedItemController::class, 'edit'])->name('founded_items.edit');
    Route::put('/founded_items/{id}', [FoundedItemController::class, 'update'])->name('founded_items.update');
    Route::delete('/founded_items/{id}', [FoundedItemController::class, 'destroy'])->name('founded_items.destroy');
  
    // History
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    // Claims untuk User Only
    Route::get('/claims/create', [ClaimUserController::class, 'create'])->name('claim_user.create');
    Route::post('/claims', [ClaimUserController::class, 'store'])->name('claim_items.store');

    // Report
    Route::get('/reports/create', [ReportsController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportsController::class, 'store'])->name('reports.store');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');

    // Claims untuk Admin Only
    Route::get('/admin/claims', [ClaimResponseController::class, 'index'])->name('claim_items.response.index');
    Route::get('/admin/claims/{id}/edit', [ClaimResponseController::class, 'edit'])->name('claim_items.response.edit');
    Route::put('/admin/claims/{id}', [ClaimResponseController::class, 'update'])->name('claim_items.response.update');


    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); 