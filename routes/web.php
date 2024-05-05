<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\HasProfileManagedClubMiddleware;
use App\Http\Middleware\HasSessionProfileMiddleware;
use App\Http\Middleware\MissingSessionProfileMiddleware;
use Illuminate\Support\Facades\Route;

// HomeController
Route::get('/', [HomeController::class, 'index'])
    ->middleware(HasSessionProfileMiddleware::class, HasProfileManagedClubMiddleware::class);
// End HomeController

// ProfileController
Route::get('/profile', [ProfileController::class, 'index'])->middleware(MissingSessionProfileMiddleware::class);

Route::get('/create-profile', [ProfileController::class, 'create'])->middleware(MissingSessionProfileMiddleware::class);

Route::get('/load-profile', [ProfileController::class, 'load'])->middleware(MissingSessionProfileMiddleware::class);

Route::get('/profile-select-club', [ProfileController::class, 'selectClub'])->middleware(HasSessionProfileMiddleware::class);
// End ProfileController
