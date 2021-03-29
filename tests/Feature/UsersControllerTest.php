<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use DatabaseTransactions;
    
    /** @test */
    public function it_can_list_all_users()
    {
        $this->get('/api/users')->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_user()
    {
        $user = User::factory()->create();
        $this->get('/api/users/' . $user->id)->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $response = $this->postJson('/api/users', ['name' => 'Sally', 'email' => 'sally@test.com']);

        $response->assertStatus(201)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->where('data.name', 'Sally')
                        ->where('data.email', 'sally@test.com')
                        ->has('data.token')
                );
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();

        $token = auth()->tokenById($user->id);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->putJson('/api/users/' . $user->id, ['name' => 'Sally Updated']);

        $response->assertStatus(200)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->where('data.name', 'Sally Updated')
                );
    }

    /** @test */
    public function it_fails_auth()
    {
        $this->getJson('/api/auth/me')->assertStatus(401);
    }

    /** @test */
    public function it_passes_auth()
    {
        $response = $this->postJson('/api/users', ['name' => 'Sally', 'email' => 'sally@test.com']);

        $response->assertStatus(201)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->where('data.name', 'Sally')
                        ->where('data.email', 'sally@test.com')
                        ->has('data.token')
                );

        $this->withHeader('Authorization', 'Bearer ' . $response->json('data.token'))->getJson('/api/auth/me')->assertStatus(200);
    }

    /** @test */
    public function it_passes_login()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/auth/login', ['email' => $user->email, 'password' => 'password']);

        $response->assertStatus(200);
    }
}
