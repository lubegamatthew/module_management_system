<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NotesController;

Route::middleware('web')->group(function () {
    Route::get('/', [PageController::class, 'login'])->name('login');
    Route::post('/login', [PageController::class, 'Authlogin'])->name('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/index', [PageController::class, 'index']);
    Route::get('/notes/index', [NotesController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NotesController::class, 'store'])->name('notes.store');
    Route::get('/notes/download/{id}', [NotesController::class, 'download'])->name('notes.download');

    //groups routes
    Route::get('/groups/members/all', [GroupController::class, 'viewMembers'])->name('members.view');
    Route::get('/groups/members/add', [GroupController::class, 'createMember'])->name('members.add');
    Route::post('/groups/members/save', [GroupController::class, 'saveMember'])->name('members.save');
});

