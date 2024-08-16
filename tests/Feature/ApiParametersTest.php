<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiParametersTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_patameter_status(): void
    {
        $response = $this->getJson('/api/parameter_status');
        $response->assertStatus(200);




        $data = [
            'name'              => 'canceled',
            'description'       => 'deal or contract canceled',
            'is_active'         => true,
            'order_condition'   => 6
        ];

        $response = $this->postJson('/api/parameter_status',$data);
        $response->assertStatus(201);
        $id = $response->json('data.id');

        $response = $this->getJson('/api/parameter_status');
        $response->assertStatus(200);
//        $response->dump();


        $response = $this->getJson('/api/parameter_status/'.$id);
        $response->assertStatus(200)
            ->assertJson(['data' => $data]);

        //$response

        $updated_data = [
            'name'              => 'updated canceled',
            'description'       => 'deal or contract canceled',
            'is_active'         => true,
            'order_condition'   => 6
        ];

        $response = $this->putJson('/api/parameter_status/'.$id,$updated_data);
        $response->assertStatus(200);

        $response = $this->getJson('/api/parameter_status/'.$id);
        $response->assertStatus(200)
            ->assertJson(['data' => $updated_data]);

    }
}
