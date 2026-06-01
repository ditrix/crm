<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Client;
use App\Models\ClientStatus;
use App\Models\Deal;
use App\Models\DealStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FakeDataSeeder extends Seeder
{
    public function run(): void
    {
        // -- Statuses --
        $statusPotential = ClientStatus::firstOrCreate(
            ['slug' => 'potential'],
            ['name' => 'Potential', 'sort_order' => 1]
        );
        $statusActive = ClientStatus::firstOrCreate(
            ['slug' => 'active'],
            ['name' => 'Active', 'sort_order' => 2]
        );

        $dealInProgress = DealStatus::firstOrCreate(
            ['slug' => 'in_progress'],
            ['name' => 'In Progress', 'sort_order' => 1]
        );
        $dealActive = DealStatus::firstOrCreate(
            ['slug' => 'active'],
            ['name' => 'Active', 'sort_order' => 2]
        );
        $dealCompleted = DealStatus::firstOrCreate(
            ['slug' => 'completed'],
            ['name' => 'Completed', 'sort_order' => 3]
        );

        // -- Users --
        $head = User::firstOrCreate(
            ['email' => 'master@mail.in'],
            ['name' => 'Master Head', 'password' => Hash::make('password'), 'is_active' => true]
        );
        $head->syncRoles([UserRole::Head->value]);

        $managers = [];
        foreach ([1, 2] as $i) {
            $manager = User::firstOrCreate(
                ['email' => "manager{$i}@mail.in"],
                ['name' => "Manager {$i}", 'password' => Hash::make('password'), 'is_active' => true]
            );
            $manager->syncRoles([UserRole::Manager->value]);
            $managers[] = $manager;
        }

        // -- Clients --

        // 10 potential clients
        for ($i = 1; $i <= 10; $i++) {
            Client::create([
                'name'             => "Potential Client {$i}",
                'email'            => "potential{$i}@example.com",
                'phone'            => '+380' . rand(1000000, 9999999),
                'company'          => "Company P{$i}",
                'client_status_id' => $statusPotential->id,
                'manager_id'       => $managers[($i - 1) % 2]->id,
            ]);
        }

        // 5 deleted clients
        for ($i = 1; $i <= 5; $i++) {
            $client = Client::create([
                'name'             => "Deleted Client {$i}",
                'email'            => "deleted{$i}@example.com",
                'phone'            => '+380' . rand(1000000, 9999999),
                'client_status_id' => $statusActive->id,
                'manager_id'       => $managers[$i % 2]->id,
            ]);
            $client->delete();
        }

        // 5 loyal active clients (will get >1 deal each)
        $loyalClients = [];
        for ($i = 1; $i <= 5; $i++) {
            $loyalClients[] = Client::create([
                'name'             => "Loyal Client {$i}",
                'email'            => "loyal{$i}@example.com",
                'phone'            => '+380' . rand(1000000, 9999999),
                'company'          => "Loyal Co {$i}",
                'client_status_id' => $statusActive->id,
                'manager_id'       => $managers[($i - 1) % 2]->id,
            ]);
        }

        // 10 regular active clients
        $regularClients = [];
        for ($i = 1; $i <= 10; $i++) {
            $regularClients[] = Client::create([
                'name'             => "Active Client {$i}",
                'email'            => "active{$i}@example.com",
                'phone'            => '+380' . rand(1000000, 9999999),
                'company'          => "Active Co {$i}",
                'client_status_id' => $statusActive->id,
                'manager_id'       => $managers[($i - 1) % 2]->id,
            ]);
        }

        // -- Deals: 100 total --

        $dealStatuses = [$dealInProgress, $dealActive, $dealCompleted];

        // Loyal clients: 3-4 deals each (5 * 4 = 20 deals)
        $dealsCreated = 0;
        foreach ($loyalClients as $idx => $client) {
            $count = ($idx < 4) ? 4 : 4; // all get 4
            for ($d = 1; $d <= $count; $d++) {
                Deal::create([
                    'title'          => "Deal #{$d} for {$client->name}",
                    'client_id'      => $client->id,
                    'deal_status_id' => $dealStatuses[($dealsCreated) % 3]->id,
                    'amount'         => rand(1000, 50000),
                ]);
                $dealsCreated++;
            }
        }

        // Regular clients: 1 deal each (10 deals)
        foreach ($regularClients as $client) {
            Deal::create([
                'title'          => "Deal for {$client->name}",
                'client_id'      => $client->id,
                'deal_status_id' => $dealStatuses[$dealsCreated % 3]->id,
                'amount'         => rand(500, 30000),
            ]);
            $dealsCreated++;
        }

        // Remaining deals distributed among all non-deleted clients
        $allActiveClients = Client::all();
        while ($dealsCreated < 100) {
            $client = $allActiveClients->random();
            Deal::create([
                'title'          => 'Deal #' . ($dealsCreated + 1),
                'client_id'      => $client->id,
                'deal_status_id' => $dealStatuses[$dealsCreated % 3]->id,
                'amount'         => rand(500, 100000),
            ]);
            $dealsCreated++;
        }
    }
}
