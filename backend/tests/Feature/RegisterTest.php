<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    // use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function test_user_can_be_created(): void
    {
        $response = $this->post('/api/register',[
            'name' => 'Teahyung',
            'username' => 'V',
            'email' => 'v@v.com',
            'password' => 'P@$$w0rd',
            'password_confirmation' => 'P@$$w0rd'
        ]);

        $response->assertStatus(201);
        $expectedUsername = 'V';
        $user = User::where('username', 'V')->firstOrFail();
        $this->assertEquals($expectedUsername, $user->username);
    }

    public function test_user_with_incomplete_or_wrong_details_can_not_be_created(): void
    {
        $response = $this->post('/api/register',[
            'name' => 'Teahyung',
            'username' => 'V',
            'password' => 'P@$$w0rd',
            'password_confirmation' => 'P@$$w0rd'
        ]);

        $response->assertStatus(302);
    }
}
