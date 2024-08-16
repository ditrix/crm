<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'                => $this->id,
            'role'              => $this->role,
            'rw_own_customer'   => $this->rw_own_customer,
            'rw_own_deals'      => $this->rw_own_deals,
            'rw_own_reports'    => $this->rw_own_reports,
            'rw_customer'       => $this->rw_customer,
            'rw_deals'          => $this->rw_deals,
            'rw_reports'        => $this->rw_reports,
            'rw_options'        => $this->rw_options,
            'rw_parameters'     => $this->rw_parameters,
            'rw_users'          => $this->rw_users,
            'role_name'         => $this->role_name,
        ];
    }
}
