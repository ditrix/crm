<?php

declare(strict_types=1);

namespace App\Http\Controllers\Deal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\StoreDealRequest;
use App\Http\Requests\Deal\UpdateDealRequest;
use App\Models\Client;
use App\Models\Deal;
use App\Models\DealStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Deal::class);

        $showArchived = $request->boolean('archived');

        $query = Deal::with(['client', 'status', 'updatedBy'])
            ->when(auth()->user()->isManager(), fn ($q) => $q->forManager(auth()->id()))
            ->when($showArchived, fn ($q) => $q->withTrashed())
            ->when(! $showArchived, fn ($q) => $q->withoutTrashed())
            ->when($request->filled('status'), fn ($q) => $q->where('deal_status_id', $request->status))
            ->when($request->filled('client'), fn ($q) => $q->where('client_id', $request->client))
            ->when($request->filled('search'), fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->latest();

        $deals    = $query->paginate(20)->withQueryString();
        $statuses = DealStatus::ordered()->get();
        $clients  = Client::mine()->get(['id', 'name']);

        return view('deals.index', compact('deals', 'statuses', 'clients', 'showArchived'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Deal::class);

        $statuses = DealStatus::ordered()->get();
        $clients  = Client::mine()->get(['id', 'name']);
        $selected = $request->filled('client_id') ? $request->integer('client_id') : null;

        return view('deals.create', compact('statuses', 'clients', 'selected'));
    }

    public function store(StoreDealRequest $request): RedirectResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();

        Deal::create($data);

        return redirect()->route('deals.index')
            ->with('success', __('messages.deal_created'));
    }

    public function show(Deal $deal): View
    {
        $this->authorize('view', $deal);

        $deal->load(['client', 'status', 'updatedBy', 'createdBy', 'files']);

        return view('deals.show', compact('deal'));
    }

    public function edit(Deal $deal): View
    {
        $this->authorize('update', $deal);

        $statuses = DealStatus::ordered()->get();
        $clients  = Client::mine()->get(['id', 'name']);

        return view('deals.edit', compact('deal', 'statuses', 'clients'));
    }

    public function update(UpdateDealRequest $request, Deal $deal): RedirectResponse
    {
        $deal->update($request->validated());

        return redirect()->route('deals.show', $deal)
            ->with('success', __('messages.deal_updated'));
    }

    public function destroy(Deal $deal): RedirectResponse
    {
        $this->authorize('delete', $deal);

        $deal->delete();

        return redirect()->route('deals.index')
            ->with('success', __('messages.deal_deleted'));
    }

    public function restore(int $id): RedirectResponse
    {
        $deal = Deal::withTrashed()->findOrFail($id);

        $this->authorize('restore', $deal);

        $deal->restore();

        return redirect()->route('deals.index', ['archived' => 1])
            ->with('success', __('messages.deal_restored'));
    }
}
