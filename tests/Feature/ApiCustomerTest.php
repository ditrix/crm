<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiCustomerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    use RefreshDatabase;

    public function test_get_customers(): void
    {

        $data = [
            'status'        => 'potencial',
            'name'          => 'test',
            'email'         => 'test@email.com',
            'phone'         => '+380660646332',
            'address'       => 'addr',
            'is_legal'      => true,
        ];
        $response = $this->postJson('api/customers',$data);
        $response->assertStatus(201);

        $id = $response->json('data.id');
//        $response->dump();

        $response = $this->getJson('api/customers');
        $response->assertStatus(200);
        //$response->dump();

        $response = $this->getJson('api/customers/'.$id);
        $response->assertStatus(200);
//        $response->dump();

        $updatedData = [
            'status'        => 'potencial',
            'name'          => 'test updated',
            'email'         => 'test@email.com',
            'phone'         => '+380660646332',
            'address'       => 'addr',
            'is_legal'      => true,
        ];

        $response = $this->putJson('api/customers/'.$id, $updatedData);

        $response->dump();

        $response->assertStatus(200);

        $response = $this->getJson('api/customers/'.$id);
        $response->assertStatus(200);
        $response->dump();


    }

}
