<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiUserTest extends TestCase
{

    public function test_index(): void
    {
        $response = $this->getJson('api/users/');
        $response->assertStatus(200);
      //  $response->dump();
    }

    public function test_user(): void
    {

        //  store user

        $data = [
            'permission_id' => 1,
            'name' => 'dmytro',
            'email' => $this->generateRandomEmail(),
            'phone' => '+38066064632',
            'password' => 'password',
            'is_active' => false
        ];


        $response = $this->postJson('api/users',$data);
        $response->assertStatus(201);


        // get user
        $id = $response->json('data.id');
        $response = $this->getJson('api/users/'.$id);
        $response->assertStatus(200);

        // get users
        $response = $this->getJson('api/users/');
        $response->assertStatus(200);

        // update user
        $data = [
            'permission_id' => 1,
            'name' => 'dmytro',
            'email' => $this->generateRandomEmail(),
            'phone' => '+38066064632',
            'password' => 'password',
            'is_active' => false
        ];
        $response = $this->postJson('api/users',$data);
        $response->assertStatus(201);
        // get user
        $id = $response->json('data.id');
        $response = $this->getJson('api/users/'.$id);
        $response->assertStatus(200);
        $updated_data = $data;
        $updated_data['name'] = 'updated dmytro';

        $response = $this->putJson('api/users/'.$id,$updated_data);
        $response = $this->getJson('api/users/'.$id);


    }

    function generateRandomEmail() {
        $username = $this->generateRandomString(10);
        $domain = $this->generateRandomString(8) . '.com';
        return $username . '@' . $domain;
    }

    function generateRandomString($length) {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

}
