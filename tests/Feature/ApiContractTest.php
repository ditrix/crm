<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Carbon\Carbon;
use Tests\TestCase;


class ApiContractTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_contract(): void
    {

        $testDate = Carbon::createFromFormat('Y-m-d', '2024-12-31');

        $data = [
            'user_id'               => 1,
            'contract_type_id'      => 1,
            'contract_status_id'    => 1,
            'code'                  => 'code',
            'comment'               => 'comment',
            'summ'                  => 222,
            'is_active'             => false,
            'active_from'           => $testDate->format('Y-m-d')
        ];

        $response = $this->postJson('api/contracts',$data);
        $response->assertStatus(201);

        $id = $response->json('data.id');

        $response = $this->getJson('api/contracts');
        $response->assertStatus(200);


        $response = $this->getJson('/api/contracts/'.$id);
        $response->assertStatus(200);

        $updated_data = $response->json('data');
        $updated_data['code'] = 'updated code';

        $response = $this->putJson('api/contracts/'.$updated_data['id'],$updated_data);
        $response->assertStatus(200);

        //$response->dump();
    }
}
