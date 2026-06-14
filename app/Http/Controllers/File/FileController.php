<?php

declare(strict_types=1);

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Deal;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
// TODO: ИЗУЧИТЬ ВОПРОСЫ ПО АРХИТЕКТУРЕ И РЕФАКТОРИЗАЦИИ ЭТОГО КОНТРОЛЛЕРА

class FileController extends Controller
{
    private const ALLOWED_MIMES = [
        'image/jpeg', 'image/png', 'image/gif', 'image/webp',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/plain',
        'application/zip',
    ];

    private const MAX_SIZE_KB = 10240; // 10 MB

    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file'          => ['required', 'file', 'max:' . self::MAX_SIZE_KB, 'mimetypes:' . implode(',', self::ALLOWED_MIMES)],
            'fileable_type' => ['required', 'in:client,deal'],
            'fileable_id'   => ['required', 'integer'],
        ]);

        [$model, $id] = $this->resolveFileable($request->fileable_type, (int) $request->fileable_id);

        $uploaded     = $request->file('file');
        $originalName = $uploaded->getClientOriginalName();
        $stored       = $uploaded->store("uploads/{$request->fileable_type}/{$id}", 'public');

        $file = File::create([
            'fileable_type' => $model::class,
            'fileable_id'   => $id,
            'original_name' => $originalName,
            'stored_name'   => basename($stored),
            'path'          => $stored,
            'mime_type'     => $uploaded->getMimeType(),
            'size'          => $uploaded->getSize(),
            'uploaded_by'   => auth()->id(),
        ]);

        return response()->json([
            'id'            => $file->id,
            'original_name' => $file->original_name,
            'size'          => $this->formatSize($file->size),
            'is_image'      => $file->isImage(),
            'url'           => Storage::url($file->path),
            'download_url'  => route('files.download', $file),
            'view_url'      => route('files.view', $file),
        ]);
    }

    public function download(File $file): StreamedResponse
    {
        $this->authorizeFileAccess($file);

        return Storage::disk('public')->download($file->path, $file->original_name);
    }

    public function view(File $file): StreamedResponse
    {
        $this->authorizeFileAccess($file);

        return Storage::disk('public')->response($file->path, $file->original_name, [
            'Content-Disposition' => 'inline; filename="' . $file->original_name . '"',
        ]);
    }

    public function destroy(File $file): JsonResponse
    {
        $this->authorizeFileAccess($file);

        Storage::disk('public')->delete($file->path);
        $file->delete();

        return response()->json(['deleted' => true]);
    }

    private function resolveFileable(string $type, int $id): array
    {
        return match($type) {
            'client' => [Client::findOrFail($id), $id],
            'deal'   => [Deal::findOrFail($id), $id],
        };
    }

    private function authorizeFileAccess(File $file): void
    {
        $user = auth()->user();

        if ($user->isAdmin() || $user->isHead()) {
            return;
        }

        // Manager: check ownership via fileable
        $fileable = $file->fileable;
        $managerId = match(true) {
            $fileable instanceof Client => $fileable->manager_id,
            $fileable instanceof Deal   => $fileable->client?->manager_id,
            default                    => null,
        };

        abort_unless($managerId === $user->id || $file->uploaded_by === $user->id, 403);
    }

    private function formatSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }

        return round($bytes / 1024, 0) . ' KB';
    }
}
