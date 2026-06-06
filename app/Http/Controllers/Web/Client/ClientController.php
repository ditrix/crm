<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Client;

use App\Actions\Client\CreateClientAction;
use App\Actions\Client\RestoreClientAction;
use App\Actions\Client\UpdateClientAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\IndexClientRequest;
use App\Http\Requests\Client\RestoreClientRequest;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Services\Client\ClientService;
use App\ViewModels\Client\ClientFormViewModel;
use App\ViewModels\Client\ClientIndexViewModel;
use App\ViewModels\Client\ClientShowViewModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(IndexClientRequest $request, ClientService $service): View
    {
        return view('clients.index', ClientIndexViewModel::from($service, $request)->toArray());
    }

    public function create(ClientService $service): View
    {
        $this->authorize('create', Client::class);

        return view('clients.create', ClientFormViewModel::forCreate($service)->toArray());
    }

    public function store(StoreClientRequest $request, CreateClientAction $action): RedirectResponse
    {
        $action->execute($request);

        return redirect()->route('clients.index')
            ->with('success', __('messages.client_created'));
    }

    public function show(Client $client, ClientService $service): View
    {
        $this->authorize('view', $client);

        return view('clients.show', (new ClientShowViewModel($service->loadForShow($client)))->toArray());
    }

    public function edit(Client $client, ClientService $service): View
    {
        $this->authorize('update', $client);

        return view('clients.edit', ClientFormViewModel::forEdit($service, $client)->toArray());
    }

    public function update(UpdateClientRequest $request, Client $client, UpdateClientAction $action): RedirectResponse
    {
        $action->execute($request, $client);

        return redirect()->route('clients.show', $client)
            ->with('success', __('messages.client_updated'));
    }

    public function destroy(Client $client, ClientService $service): RedirectResponse
    {
        $this->authorize('delete', $client);

        $service->delete($client);

        return redirect()->route('clients.index')
            ->with('success', __('messages.client_deleted'));
    }

    public function restore(RestoreClientRequest $request, RestoreClientAction $action): RedirectResponse
    {
        $client = Client::withTrashed()->findOrFail((int) $request->validated('id'));

        $action->execute($client);

        return redirect()->route('clients.index', ['archived' => 1])
            ->with('success', __('messages.client_restored'));
    }
}
