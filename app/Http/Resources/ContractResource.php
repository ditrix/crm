<?php

namespace App\Http\Resources;

use App\Models\ContractStatus;
use App\Models\ContractType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */


    public function toArray(Request $request): array
    {

        $contract_type = ContractType::where('id',$this->contract_type_id)->first();

        return [
            'id'                    => $this->id,
            'user_id'               => $this->user_id,
            'customer_id'           => $this->customer_id,
            'contract_type_id'      => $this->contract_type_id,
            'contract_status_id'    => $this->contract_status_id,
            'code'                  => $this->code,
            'title'                 => $this->title,
            'comment'               => $this->comment,
            'summ'                  => $this->summ,
            'is_active'             => $this->is_active,
            'active_from'           => $this->active_from,
            'active_to'             => $this->active_to,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
            'customer'              => $this->customer->name,
            'type'                  => $contract_type->title,
            'status'                => new ContractStatusResource($this->whenLoaded('contract_status')),
            'statuses'              => ContractStatusResource::collection(ContractStatus::all()),
        ];
    }
}
