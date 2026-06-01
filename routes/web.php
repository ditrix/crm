<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Deal\DealController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Settings\ClientStatusController;
use App\Http\Controllers\Settings\DealStatusController;
use App\Http\Controllers\Settings\SystemSettingsController;
use App\Http\Controllers\Tools\CalendarController;
use App\Http\Controllers\Tools\NoteController;
use App\Http\Controllers\Tools\ReminderController;
use App\Http\Controllers\Tools\TaskController;
use App\Http\Controllers\User\UserController;
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

        // Profile
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

        // Users management (admin + head)
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update']);

        // Clients
        Route::resource('clients', ClientController::class);
        Route::post('clients/{id}/restore', [ClientController::class, 'restore'])->name('clients.restore');

        // Deals
        Route::resource('deals', DealController::class);
        Route::post('deals/{id}/restore', [DealController::class, 'restore'])->name('deals.restore');

        // Managers (head/admin only)
        Route::prefix('managers')->name('managers.')->group(function () {
            Route::get('/', [ManagerController::class, 'index'])->name('index');
            Route::get('{user}', [ManagerController::class, 'show'])->name('show');
            Route::post('{user}/toggle', [ManagerController::class, 'toggle'])->name('toggle');
            Route::post('clients/{client}/assign', [ManagerController::class, 'assignClient'])->name('assign-client');
        });

        // File uploads
        Route::prefix('files')->name('files.')->group(function () {
            Route::post('upload', [FileController::class, 'upload'])->name('upload');
            Route::get('{file}/download', [FileController::class, 'download'])->name('download');
            Route::get('{file}/view', [FileController::class, 'view'])->name('view');
            Route::delete('{file}', [FileController::class, 'destroy'])->name('destroy');
        });

        // Tools
        Route::prefix('tools')->name('tools.')->group(function () {            // Tasks
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

        // Settings (admin only)
        Route::prefix('settings')->name('settings.')->middleware('role:admin')->group(function () {
            // System log — handled by opcodesio/log-viewer at /log-viewer (gate: viewLogViewer)

            // System settings
            Route::get('/', [SystemSettingsController::class, 'index'])->name('index');
            Route::patch('/', [SystemSettingsController::class, 'update'])->name('update');

            // Client statuses
            Route::get('client-statuses', [ClientStatusController::class, 'index'])->name('client-statuses.index');
            Route::post('client-statuses', [ClientStatusController::class, 'store'])->name('client-statuses.store');
            Route::patch('client-statuses/{clientStatus}', [ClientStatusController::class, 'update'])->name('client-statuses.update');
            Route::delete('client-statuses/{clientStatus}', [ClientStatusController::class, 'destroy'])->name('client-statuses.destroy');
            Route::post('client-statuses/{id}/restore', [ClientStatusController::class, 'restore'])->name('client-statuses.restore');

            // Deal statuses
            Route::get('deal-statuses', [DealStatusController::class, 'index'])->name('deal-statuses.index');
            Route::post('deal-statuses', [DealStatusController::class, 'store'])->name('deal-statuses.store');
            Route::patch('deal-statuses/{dealStatus}', [DealStatusController::class, 'update'])->name('deal-statuses.update');
            Route::delete('deal-statuses/{dealStatus}', [DealStatusController::class, 'destroy'])->name('deal-statuses.destroy');
            Route::post('deal-statuses/{id}/restore', [DealStatusController::class, 'restore'])->name('deal-statuses.restore');
        });
    });
});
