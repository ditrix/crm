<?php

declare(strict_types=1);

namespace App\Services\Settings;

final class SystemSettingsService
{
    public function getSettings(): array
    {
        return [
            'app_name' => config('app.name'),
            'default_locale' => config('app.locale'),
        ];
    }

    public function update(array $data): void
    {
        $this->setEnvValue('APP_NAME', '"'.$data['app_name'].'"');
        $this->setEnvValue('APP_LOCALE', $data['default_locale']);
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
            $content .= PHP_EOL."{$key}={$value}";
        }

        file_put_contents($envPath, $content);
    }
}
