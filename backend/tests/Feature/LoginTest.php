<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_user_login_returns_token(): void
    // {
    //     $response = $this->post('/api/login',[
    //         'email' => 'v@v.com',
    //         'password' => 'P@$$w0rd'
    //     ]);

    //     $response->assertStatus(200);
    // }

    public function test_user_login_cannot_return_correct_token_when_failed()
    {
        $response = $this->post('/api/login', [
            'email' => 'test11@example.com',
            'password' => 'password23'
        ], ['Accept' => 'application/json']);

        $response->assertStatus(403);
    }
}
