<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiContractTypeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_contract_type(): void
    {
        $response = $this->getJson('/api/contract_type');
        $response->assertStatus(200);

        $data = [
            'code'              => 'contract_type_1',
            'title'             => 'contract_type 1',
            'is_active'         => true,
            'order_condition'   => 1
        ];

        $response = $this->postJson('/api/contract_type',$data);
        $response->assertStatus(201);
        $id = $response->json('data.id');

        //$response->dump();

        $response = $this->getJson('/api/contract_type');
        $response->assertStatus(200);
       //$response->dump();


        $response = $this->getJson('/api/contract_type/'.$id);
        $response->assertStatus(200)
            ->assertJson(['data' => $data]);


        $updated_data = [
            'code'              => 'contract_type_1',
            'title'             => 'updated contract_type 1',
            'is_active'         => true,
            'order_condition'   => 1
        ];

        $response = $this->putJson('/api/contract_type/'.$id,$updated_data);
        $response->assertStatus(200);

        $response = $this->getJson('/api/contract_type/'.$id);
        $response->assertStatus(200)
            ->assertJson(['data' => $updated_data]);

    }
}
