<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Database\Seeders\User\InitPermissionSeeder;
use Database\Seeders\Parameter\ParameterStatusSeeder;
use Database\Seeders\Parameter\ContractTypeSeeder;
use Database\Seeders\Customer\InitDevCustomerSeeder;
use Database\Seeders\Parameter\InitDevContractStatusSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // $this->call([
        //     InitPermissionSeeder::class
        // ]);


        //  \App\Models\User::factory(4)->create();

        // $this->call([
        //     ParameterStatusSeeder::class
        // ]);

        $this->call([
            InitDevContractStatusSeeder::class
        ]);

        //$this->InitDevContractStatusSeeder

        // $this->call([
        //     ContractTypeSeeder::class
        // ]);

        // $this->call([
        //     InitDevCustomerSeeder::class
        // ]);

    }
}
