<?php

declare(strict_types=1);

namespace App\Actions\Client;

use App\Http\Requests\Client\StoreClientRequest;
use App\Models\Client;

final class CreateClientAction
{
    public function execute(StoreClientRequest $request): Client
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        if (auth()->user()->isManager()) {
            $data['manager_id'] = auth()->id();
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('clients', 'public');
        } else {
            unset($data['avatar']);
        }

        return Client::create($data);
    }
}
