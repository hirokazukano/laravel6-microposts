<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
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
        $this->seed();
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
