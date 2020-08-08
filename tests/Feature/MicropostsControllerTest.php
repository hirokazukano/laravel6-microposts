<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MicropostsControllerTest extends TestCase
{
    // テスト毎にmigrationを実行
    use RefreshDatabase;

    /**
     * - テスト実行前に呼ばれる
     * - テストデータの準備などの前処理に使う
     * - 書かなくてもOK
     */
    public function setUp(): void
    {
        parent::setUp();
        // seederを実行
        $this->seed(['UsersTableSeeder']);
    }

    /**
     * - テスト実行最後に呼ばれる
     * - テスト後処理などで使う
     * - 書かなくてもOK
     *
     * @throws \Throwable
     */
    public function tearDown(): void
    {
        parent::tearDown();
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
        $response->assertSeeText('ようこそマイクロポストヘ');
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group microposts
     */
    public function ログイン状態TOPページアクセスでユーザー名が表示されること()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('user1');
        $this->assertTrue(\Auth::check());
    }
}
