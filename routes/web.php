<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Deal\DealController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Tools\CalendarController;
use App\Http\Controllers\Tools\NoteController;
use App\Http\Controllers\Tools\ReminderController;
use App\Http\Controllers\Tools\TaskController;
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

        // User tools
        Route::prefix('tools')->name('tools.')->group(function () {
            // Tasks
            Route::get('tasks', [TaskController::class, 'index'])->name('tasks');
            Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
            Route::post('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
            Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

            // Note
            Route::get('note', [NoteController::class, 'index'])->name('note');
            Route::patch('note', [NoteController::class, 'update'])->name('note.update');

            // Calendar
            Route::get('calendar', [CalendarController::class, 'index'])->name('calendar');
            Route::post('calendar', [CalendarController::class, 'store'])->name('calendar.store');
            Route::delete('calendar/{calendarEvent}', [CalendarController::class, 'destroy'])->name('calendar.destroy');

            // Reminders
            Route::get('reminders', [ReminderController::class, 'index'])->name('reminders');
            Route::post('reminders', [ReminderController::class, 'store'])->name('reminders.store');
            Route::post('reminders/{reminder}/dismiss', [ReminderController::class, 'dismiss'])->name('reminders.dismiss');
            Route::delete('reminders/{reminder}', [ReminderController::class, 'destroy'])->name('reminders.destroy');
            Route::get('reminders/pending', [ReminderController::class, 'pending'])->name('reminders.pending');
        });
    });
});
