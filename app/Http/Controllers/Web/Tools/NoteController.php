<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Tools;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Services\Note\NoteService;
use App\ViewModels\Note\NoteIndexViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(NoteService $service): View
    {
        return view('tools.note', NoteIndexViewModel::from($service->getOrCreateForUser(auth()->user()))->toArray());
    }

    public function update(UpdateNoteRequest $request, NoteService $service): JsonResponse
    {
        $service->updateForUser($request->user(), $request->validated('content'));

        return response()->json(['saved' => true]);
    }
}
