<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Models\ClientStatus;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Client::class);

        $showArchived = $request->boolean('archived');

        $query = Client::with(['status', 'manager', 'updatedBy'])
            ->mine()
            ->when($showArchived, fn ($q) => $q->withTrashed())
            ->when(! $showArchived, fn ($q) => $q->withoutTrashed())
            ->when($request->filled('status'), fn ($q) => $q->where('client_status_id', $request->status))
            ->when($request->filled('manager'), fn ($q) => $q->where('manager_id', $request->manager))
            ->when($request->filled('search'), fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%")
                  ->orWhere('company', 'like', "%{$request->search}%");
            }))
            ->latest();

        $clients  = $query->paginate(20)->withQueryString();
        $statuses = ClientStatus::ordered()->get();
        $managers = User::active()->role('manager')->get();

        return view('clients.index', compact('clients', 'statuses', 'managers', 'showArchived'));
    }

    public function create(): View
    {
        $this->authorize('create', Client::class);

        $statuses = ClientStatus::ordered()->get();
        $managers = User::active()->role('manager')->get();

        return view('clients.create', compact('statuses', 'managers'));
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $data             = $request->validated();
        $data['created_by'] = auth()->id();

        Client::create($data);

        return redirect()->route('clients.index')
            ->with('success', __('messages.client_created'));
    }

    public function show(Client $client): View
    {
        $this->authorize('view', $client);

        $client->load(['status', 'manager', 'deals.status', 'updatedBy', 'createdBy']);

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client): View
    {
        $this->authorize('update', $client);

        $statuses = ClientStatus::ordered()->get();
        $managers = User::active()->role('manager')->get();

        return view('clients.edit', compact('client', 'statuses', 'managers'));
    }

    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()->route('clients.show', $client)
            ->with('success', __('messages.client_updated'));
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->authorize('delete', $client);

        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', __('messages.client_deleted'));
    }

    public function restore(int $id): RedirectResponse
    {
        $client = Client::withTrashed()->findOrFail($id);

        $this->authorize('restore', $client);

        $client->restore();

        return redirect()->route('clients.index', ['archived' => 1])
            ->with('success', __('messages.client_restored'));
    }
}
