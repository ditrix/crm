<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(): View
    {
        $note = Note::firstOrCreate(
            ['user_id' => auth()->id()],
            ['content' => '']
        );

        return view('tools.note', compact('note'));
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate(['content' => ['nullable', 'string']]);

        Note::updateOrCreate(
            ['user_id' => auth()->id()],
            ['content' => $request->content ?? '']
        );

        return response()->json(['saved' => true]);
    }
}
