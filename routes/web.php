<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GroupController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [ChatController::class, 'index'])->name('dashboard');

    // Chat Personal
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chat.store');
    Route::post('/typing/{user}', [ChatController::class,'typing']);

    // Group Chat
    Route::get('/group/{group}', [GroupController::class,'show'])->name('group.show');
    Route::post('/group/{group}', [GroupController::class,'store'])->name('group.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';