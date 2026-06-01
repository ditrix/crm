<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SystemSettingsController extends Controller
{
    public function index(): View
    {
        $settings = [
            'app_name'        => config('app.name'),
            'default_locale'  => config('app.locale'),
        ];

        return view('settings.system.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'app_name'       => ['required', 'string', 'max:100'],
            'default_locale' => ['required', 'in:en,ua,ru'],
        ]);

        // Persist to .env
        $this->setEnvValue('APP_NAME', '"' . $request->app_name . '"');
        $this->setEnvValue('APP_LOCALE', $request->default_locale);

        return back()->with('success', __('messages.settings_saved'));
    }

    private function setEnvValue(string $key, string $value): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            return;
        }

        $content = file_get_contents($envPath);

        if (preg_match("/^{$key}=.*/m", $content)) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
        } else {
            $content .= PHP_EOL . "{$key}={$value}";
        }

        file_put_contents($envPath, $content);
    }
}
