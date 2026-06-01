<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SystemLogController extends Controller
{
    private const LINES_PER_PAGE = 100;

    public function index(Request $request): View
    {
        abort_unless(auth()->user()?->isAdmin(), 403);

        $logPath = storage_path('logs/laravel.log');
        $lines   = [];
        $total   = 0;

        if (file_exists($logPath)) {
            $all   = array_reverse(file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
            $total = count($all);
            $page  = max(1, (int) $request->input('page', 1));
            $lines = array_slice($all, ($page - 1) * self::LINES_PER_PAGE, self::LINES_PER_PAGE);
        }

        $page     = max(1, (int) $request->input('page', 1));
        $lastPage = max(1, (int) ceil($total / self::LINES_PER_PAGE));

        return view('settings.log.index', compact('lines', 'total', 'page', 'lastPage'));
    }
}
