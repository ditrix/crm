<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Http\Resources\UserResource;


class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'status'        => $this->status,
            'status_name'   => $this->status_name,
            'name'          => $this->name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'is_active'     => $this->is_active,
            'is_legal'      => $this->is_legal,
            'code'          => $this->code,
            'contact_name'  => $this->contact_name,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'deleted_at'    => $this->deleted_at,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'description'   => $this->description,
            'user'          => new UserResource($this->whenLoaded('user')),
            'users'         => UserResource::collection(User::all()),
            'contracts'     => $this->contracts
        ];
        // 'users' => UserResource::collection(User::all()), данные для select списка
    }
}
