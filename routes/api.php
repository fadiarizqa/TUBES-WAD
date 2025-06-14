<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClaimUserApiController;
use App\Http\Controllers\Api\ClaimResponseApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\HistoryApiController;
use App\Http\Controllers\Api\LostItemApiController;
use App\Http\Controllers\Api\ReportsApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\FoundedItemApiController;
use App\Http\Controllers\Api\HomeApiController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function() {

    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/lost_items', [LostItemApiController::class, 'index'])->name('lost_items.index');
    Route::get('/lost_items/create', [LostItemApiController::class, 'create'])->name('lost_items.create');
    Route::post('/lost_items', [LostItemApiController::class, 'store'])->name('lost_items.store');
    Route::get('/lost_items/{id}/edit', [LostItemApiController::class, 'edit'])->name('lost_items.edit');
    Route::put('/lost_items/{id}', [LostItemApiController::class, 'update'])->name('lost_items.update');
    Route::post('/lost_items/{id}/comments', [CommentApiController::class, 'store'])->name('comments.store');
    Route::get('/lost_items/{id}/comments/{comment}/edit', [CommentApiController::class, 'edit'])->name('comments.edit');
    Route::put('/lost_items/{id}/comments/{comment}', [CommentApiController::class, 'update'])->name('comments.update');
    Route::delete('/lost_items/{id}/comments/{comment}', [CommentApiController::class, 'destroy'])->name('comments.destroy');
    Route::post('/lost_items', [LostItemApiController::class, 'store'])->name('lost_items.store');
    Route::get('/lost_items/{id}', [LostItemApiController::class, 'show'])->name('lost_items.show');
    Route::delete('/lost_items/{id}', [LostItemApiController::class, 'destroy'])->name('lost_items.destroy');

    // Founded Items
    Route::get('/founded_items', [FoundedItemApiController::class, 'index'])->name('founded_items.index');
    Route::get('/founded_items/create', [FoundedItemApiController::class, 'create'])->name('founded_items.create');
    Route::post('/founded_items', [FoundedItemApiController::class, 'store'])->name('founded_items.store');
    Route::get('/founded_items/{id}', [FoundedItemApiController::class, 'show'])->name('founded_items.show');
    Route::get('/founded_items/{id}/comments', [CommentApiController::class, 'index'])->name('comments.index');
    Route::post('/founded_items/{id}/comments', [CommentApiController::class, 'store'])->name('comments.store');
    Route::get('/founded_items/{id}/comments/{comment}/edit', [CommentApiController::class, 'edit'])->name('comments.edit');
    Route::put('/founded_items/{id}/comments/{comment}', [CommentApiController::class, 'update'])->name('comments.update');
    Route::delete('/founded_items/{id}/comments/{comment}', [CommentApiController::class, 'destroy'])->name('comments.destroy');
    Route::get('/founded_items/{id}/edit', [FoundedItemApiController::class, 'edit'])->name('founded_items.edit');
    Route::put('/founded_items/{id}', [FoundedItemApiController::class, 'update'])->name('founded_items.update');
    Route::delete('/founded_items/{id}', [FoundedItemApiController::class, 'destroy'])->name('founded_items.destroy');
  
    // History
    Route::get('/history', [HistoryApiController::class, 'index'])->name('history.index');

    // Claims untuk User Only
    Route::get('/claims/create', [ClaimUserApiController::class, 'create'])->name('claim_user.create');
    Route::post('/claims', [ClaimUserApiController::class, 'store'])->name('claim_items.store');

    // Report
    Route::get('/reports/create', [ReportsApiController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportsApiController::class, 'store'])->name('reports.store');
    Route::get('/admin/reports', [ReportsApiController::class, 'index'])->name('reports.index');
    Route::get('/admin/reports/{id}', [ReportsApiController::class, 'show'])->name('reports.show');
    Route::put('/admin/reports/{id}', [ReportsApiController::class, 'update'])->name('reports.update');
    Route::delete('/admin/reports/{id}', [ReportsApiController::class, 'destroy'])->name('reports.destroy');
    Route::delete('/admin/reports/post/{report}', [ReportsApiController::class, 'destroyPost'])->name('reports.destroyPost');

    // Claims untuk Admin Only
    Route::get('/admin/claims', [ClaimResponseApiController::class, 'index'])->name('claim_items.response.index');
    Route::delete('/admin/claims/{id}', [ClaimResponseApiController::class, 'destroy'])->name('claim_items.response.destroy');
    Route::put('/admin/claims/{id}', [ClaimResponseApiController::class, 'update'])->name('claim_items.response.update');
    Route::get('/admin/claims/{id}', [ClaimResponseApiController::class, 'show'])->name('admin.claims.show');

    Route::get('/profile/edit', [ProfileApiController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileApiController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileApiController::class, 'destroy'])->name('profile.destroy');
}); 

