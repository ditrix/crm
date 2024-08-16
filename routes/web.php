<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DebugController;

Route::get('/debug',  [DebugController::class, 'index'])->name('debug');

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');


require __DIR__.'/auth.php';
