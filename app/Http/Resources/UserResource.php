<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PermissionResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        //return parent::toArray($request);
        return [
            'id'            => $this->id,
            'permission_id' => $this->permission_id,
            'is_active'     => $this->is_active,
            'name'          => $this->name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'password'      => $this->password,
            'permission'    => new PermissionResource($this->whenLoaded('permission')),
            'role_name'     => $this->role_name,
        ];

    }
}
