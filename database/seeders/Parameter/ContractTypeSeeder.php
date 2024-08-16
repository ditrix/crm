<?php

namespace Database\Seeders\Parameter;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContractType;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contract_type = ContractType::where('code','sale_and_purchace')->first();

        if(!$contract_type) {
            ContractType::create([
                'code'              => 'sale_and_purchace',
                'title'             => 'Sale and Purchase',
                'is_active'         => true,
                'order_condition'   => 1
            ]);
        }

        $contract_type = ContractType::where('code','supply_contract')->first();

        if(!$contract_type) {
            ContractType::create([
                'code'              => 'supply_contract',
                'title'             => 'Supply Contract',
                'is_active'         => true,
                'order_condition'   => 2
            ]);
        }

        $contract_type = ContractType::where('code','service_contract')->first();

        if(!$contract_type) {
            ContractType::create([
                'code'              => 'service_contract',
                'title'             => 'Service Contract',
                'is_active'         => true,
                'order_condition'   => 3
            ]);
        }

    }
}
