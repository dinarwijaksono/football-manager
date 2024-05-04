<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\HasSessionProfileMiddleware;
use App\Http\Middleware\MissingSessionProfileMiddleware;
use Illuminate\Support\Facades\Route;

// HomeController
Route::get('/', [HomeController::class, 'index'])->middleware(HasSessionProfileMiddleware::class);
// End HomeController

// ProfileController
Route::get('/profile', [ProfileController::class, 'index'])->middleware(MissingSessionProfileMiddleware::class);

Route::get('/create-profile', [ProfileController::class, 'create'])->middleware(MissingSessionProfileMiddleware::class);
// End ProfileController