<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group login
     */
    public function 存在しないユーザー情報でログインができないこと()
    {
        $response = $this->post('/login', [
            'email' => 'test@gmail.com',
            'password' => 'test',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group login
     */
    public function ログインができること()
    {
        $response = $this->post('/login', [
            'email' => 'user1@gmail.com',
            'password' => 'himituhimitu',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertTrue(\Auth::check());
    }
}
