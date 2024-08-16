<?php

namespace Database\Seeders\Parameter;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractStatus;

class InitDevContractStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contract_status = ContractStatus::where('name','offer')->first();

        if(!$contract_status) {
            ContractStatus::create([
                'name'              => 'offer',
                'description'       => 'offer of deal or contract',
                'is_active'         => true,
                'order_condition'   => 1
            ]);
        }

        $contract_status = ContractStatus::where('name','conversation')->first();

        if(!$contract_status) {
            ContractStatus::create([
                'name'              => 'conversation',
                'description'       => 'negotiation of terms',
                'is_active'         => true,
                'order_condition'   => 2
            ]);
        }

        $contract_status = ContractStatus::where('name','concluded')->first();

        if(!$contract_status) {
            ContractStatus::create([
                'name'              => 'concluded',
                'description'       => 'deal or contract concluded',
                'is_active'         => true,
                'order_condition'   => 3
            ]);
        }

        $contract_status = ContractStatus::where('name','current')->first();

        if(!$contract_status) {
            ContractStatus::create([
                'name'              => 'current',
                'description'       => 'deal or contract current',
                'is_active'         => true,
                'order_condition'   => 4
            ]);
        }

        $contract_status = ContractStatus::where('name','completed')->first();

        if(!$contract_status) {
            ContractStatus::create([
                'name'              => 'completed',
                'description'       => 'deal or contract completed',
                'is_active'         => true,
                'order_condition'   => 5
            ]);
        }

        $contract_status = ContractStatus::where('name','canceled')->first();

        if(!$contract_status) {
            ContractStatus::create([
                'name'              => 'canceled',
                'description'       => 'deal or contract canceled',
                'is_active'         => true,
                'order_condition'   => 6
            ]);
        }
    }
}
