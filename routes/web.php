<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FoundedItemController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\UserController;


// Claim Routes

// Comment Routes

// Founded Item Routes

// History Routes

// Lost Item Routes
Route::get('/lost_items', [LostItemController::class, 'index'])->name('lost_items.index');
Route::get('/lost_items/create', [LostItemController::class, 'create'])->name('lost_items.create');
Route::post('/lost_items', [LostItemController::class, 'store'])->name('lost_items.store');

