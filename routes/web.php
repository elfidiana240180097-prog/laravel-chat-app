<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [ChatController::class, 'index'])->name('dashboard');

    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');

    Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chat.store');

    Route::post('/typing/{user}',[ChatController::class,'typing']);

    // ROUTE BARU UNTUK TYPING
    Route::post('/chat/{user}/typing', [ChatController::class, 'typing'])->name('chat.typing');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';