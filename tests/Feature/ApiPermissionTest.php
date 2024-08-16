<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiPermissionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function _test_get(): void
    {
        $response = $this->getJson('api/permissions');

        $response->assertStatus(200);
    }


    public function _test_permission_foo() {


        $data = [
            'role'              => 'top_manager',
            'rw_own_customer'   => true,
            'rw_own_deals'      => true,
            'rw_own_reports'    => true,
            'rw_customer'       => true,
            'rw_deals'          => true,
            'rw_reports'        => true,
            'rw_options'        => false,
            'rw_parameters'     => false,
            'rw_users'          => false
        ];

        $response = $this->postJson('api/permissions',$data);
        $response->assertStatus(201);

        $id = $response->json('data.id');

        $response = $this->getJson('api/permissions/'.$id);

       // $response->dump();

        $response->assertStatus(200)
            ->assertJson(['data' => $data]);

        $updated_data = [
            'role'       => 'top_manager',
            'rw_own_customer'   => false,
            'rw_own_deals'      => false,
            'rw_own_reports'    => false,
            'rw_customer'       => false,
            'rw_deals'          => false,
            'rw_reports'        => false,
            'rw_options'        => false,
            'rw_parameters'     => false,
            'rw_users'          => false
        ];

        $response = $this->putJson('api/permissions/'.$id,$updated_data);
        $response = $this->getJson('api/permissions/'.$id);
        $response->assertStatus(200)
            ->assertJson(['data' => $updated_data]);
       // $response->dump();
    }
}
