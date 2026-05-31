<?php

declare(strict_types=1);

namespace App\Traits;

trait HasTrackedChanges
{
    public static function bootHasTrackedChanges(): void
    {
        static::updating(function (self $model): void {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }
}
