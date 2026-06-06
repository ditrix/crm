<?php

declare(strict_types=1);

namespace App\Actions\Client;

use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;

final class UpdateClientAction
{
    public function execute(UpdateClientRequest $request, Client $client): Client
    {
        $data = $request->safe()->except(['avatar', 'remove_avatar']);

        if ($request->hasFile('avatar')) {
            if ($client->avatar) {
                Storage::disk('public')->delete($client->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('clients', 'public');
        } elseif ($request->boolean('remove_avatar') && $client->avatar) {
            Storage::disk('public')->delete($client->avatar);
            $data['avatar'] = null;
        }

        $client->update($data);

        return $client;
    }
}
