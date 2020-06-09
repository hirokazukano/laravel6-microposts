<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    const MY_USER_ID = 1;

    /**
     * @var User
     */
    private $_user;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->_user = User::find(self::MY_USER_ID);
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group user
     */
    public function 新規followでtrueになること()
    {
        $this->assertTrue($this->_user->follow(8));
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group user
     */
    public function follow済みユーザーをfollowでfalseになること()
    {
        $this->assertFalse($this->_user->follow(2));
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group user
     */
    public function 自分自身をfollowでfalseになること()
    {
        $this->assertFalse($this->_user->follow(self::MY_USER_ID));
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group user
     */
    public function unFollow成功でtrueになること()
    {
        $this->assertTrue($this->_user->unFollow(2));
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group user
     */
    public function 自分自身をunFollowでfalseになること()
    {
        $this->assertFalse($this->_user->unFollow(self::MY_USER_ID));
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group user
     */
    public function is_followingでフォロー済みの場合trueになること()
    {
        $this->assertTrue($this->_user->is_following(2));
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group user
     */
    public function is_followingで未フォローの場合falseになること()
    {
        $this->assertFalse($this->_user->is_following(8));
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group user
     */
    public function feed_micropostsで自分とフォローユーザーのpost一覧を取得できること()
    {
        $response = $this->_user->feed_microposts();
        $this->assertEquals(6, $response->count());
    }

    /** @noinspection NonAsciiCharacters */
    /**
     * @test
     * @group user-tmp
     */
    public function favoritesを取得できること()
    {
        $response = $this->_user->favorites();
        $this->assertEquals(4, $response->count());
    }
}
