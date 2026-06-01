<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    protected $fillable = [
        'fileable_type',
        'fileable_id',
        'original_name',
        'stored_name',
        'path',
        'mime_type',
        'size',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type ?? '', 'image/');
    }

    public function isPdf(): bool
    {
        return ($this->mime_type ?? '') === 'application/pdf';
    }

    public function formattedSize(): string
    {
        if ($this->size >= 1048576) {
            return round($this->size / 1048576, 1) . ' MB';
        }

        return round($this->size / 1024, 0) . ' KB';
    }

    public function icon(): string
    {
        if ($this->isImage()) {
            return '🖼️';
        }

        return match($this->mime_type ?? '') {
            'application/pdf'                                                                 => '📕',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'        => '📝',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'              => '📊',
            'application/zip'                                                                 => '🗜️',
            default                                                                           => '📄',
        };
    }
}
