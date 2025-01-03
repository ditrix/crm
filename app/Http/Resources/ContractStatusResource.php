<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractStatusResource extends JsonResource
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
            'name'              => $this->name,
            'description'       => $this->description,
            'is_active'         => $this->is_active,
            'order_condition'   => $this->order_condition
        ];
    }
}
