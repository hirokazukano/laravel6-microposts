<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MicropostsControllerTest extends TestCase
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
     * @group microposts
     */
    public function 未ログイン状態TOPページアクセスでWelcomeが表示されること()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Welcome');
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group microposts
     */
    public function 未ログイン状態TOPページアクセスでユーザー名が表示されること()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('user1');
        $this->assertTrue(\Auth::check());
    }
}
