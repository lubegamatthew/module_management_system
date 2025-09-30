<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::middleware('web')->group(function () {
    Route::get('/', [PageController::class, 'login']);
    Route::post('/login', [PageController::class, 'Authlogin'])->name('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/index', [PageController::class, 'index']);
});

