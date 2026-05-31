<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Deal\DealController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

// Locale switcher
Route::get('/locale/{locale}', function (string $locale) {
    $supported = ['en', 'ua', 'ru'];

    if (in_array($locale, $supported, true)) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('locale.switch');

// Auth
Route::middleware(SetLocale::class)->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Authenticated routes
    Route::middleware('auth')->group(function () {
        Route::get('/', fn () => redirect()->route('dashboard'));
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        // Clients
        Route::resource('clients', ClientController::class);
        Route::post('clients/{id}/restore', [ClientController::class, 'restore'])->name('clients.restore');

        // Deals
        Route::resource('deals', DealController::class);
        Route::post('deals/{id}/restore', [DealController::class, 'restore'])->name('deals.restore');

        // Managers (head/admin only)
        Route::prefix('managers')->name('managers.')->group(function () {
            Route::get('/', [ManagerController::class, 'index'])->name('index');
            Route::post('{user}/toggle', [ManagerController::class, 'toggle'])->name('toggle');
            Route::post('clients/{client}/assign', [ManagerController::class, 'assignClient'])->name('assign-client');
        });
    });
});
