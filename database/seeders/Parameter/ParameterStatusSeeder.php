<?php

namespace Database\Seeders\Parameter;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParameterStatus;

class ParameterStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parameter_status = ParameterStatus::where('name','offer')->first();

        if(!$parameter_status) {
            ParameterStatus::create([
                'name'              => 'offer',
                'description'       => 'offer of deal or contract',
                'is_active'         => true,
                'order_condition'   => 1
            ]);
        }

        $parameter_status = ParameterStatus::where('name','conversation')->first();

        if(!$parameter_status) {
            ParameterStatus::create([
                'name'              => 'conversation',
                'description'       => 'negotiation of terms',
                'is_active'         => true,
                'order_condition'   => 2
            ]);
        }

        $parameter_status = ParameterStatus::where('name','concluded')->first();

        if(!$parameter_status) {
            ParameterStatus::create([
                'name'              => 'concluded',
                'description'       => 'deal or contract concluded',
                'is_active'         => true,
                'order_condition'   => 3
            ]);
        }

        $parameter_status = ParameterStatus::where('name','current')->first();

        if(!$parameter_status) {
            ParameterStatus::create([
                'name'              => 'current',
                'description'       => 'deal or contract current',
                'is_active'         => true,
                'order_condition'   => 4
            ]);
        }

        $parameter_status = ParameterStatus::where('name','completed')->first();

        if(!$parameter_status) {
            ParameterStatus::create([
                'name'              => 'completed',
                'description'       => 'deal or contract completed',
                'is_active'         => true,
                'order_condition'   => 5
            ]);
        }

        $parameter_status = ParameterStatus::where('name','canceled')->first();

        if(!$parameter_status) {
            ParameterStatus::create([
                'name'              => 'canceled',
                'description'       => 'deal or contract canceled',
                'is_active'         => true,
                'order_condition'   => 6
            ]);
        }


    }
}
