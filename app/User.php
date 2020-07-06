<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Micropost[] $microposts
 * @property-read int|null $microposts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * 型キャストする
     *
     * @link https://readouble.com/laravel/6.x/ja/eloquent-mutators.html
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * sql: 'select * from `microposts` where `microposts`.`user_id` = ? and `microposts`.`user_id` is not null'
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }

    /**
     * loadRelationshipCountsの動作説明
     *
     * @return array
     */
    public function getRelationshipCounts()
    {
        return [
            'microposts_count' => $this->microposts()->count(),
            'followings_count' => $this->followings()->count(),
            'followers_count' => $this->followers()->count(),
            'favorites_count' => $this->favorites()->count(),
        ];
    }

    /**
     * 関連するモデルのカウント取得
     * $user->attributesにmicroposts_count、followings_countなどで追加される
     * $this->microposts()->count()と同じこと
     *
     * @see https://readouble.com/laravel/6.x/ja/eloquent-relationships.html#counting-related-models
     * @return User
     */
    public function loadRelationshipCounts()
    {
        return $this->loadCount(['microposts', 'followings', 'followers', 'favorites']);
    }

    /**
     * 自分がフォローしているUserを取得
     * belongsToMany(関連づけるモデル名, 使用する中間テーブル名, 自分のidのカラム名, 相手のidのカラム名);
     *
     * sql: select * from `users` inner join `user_follow` on `users`.`id` = `user_follow`.`follow_id` where `user_follow`.`user_id` = ?';
     * 1. select * from `users` inner join `user_follow` on `users`.`id` = `user_follow`.`follow_id`; = 全ユーザーがフォローしているユーザー一覧を取得
     * 2. where `user_follow`.`user_id` = ?'; = 自分がフォローしているユーザーに絞り込み
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        // var_dump($this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->toSql());
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')
            ->withTimestamps();
    }

    /**
     * 自分をフォローしているUserを取得
     * belongsToMany(関連づけるモデル名, 使用する中間テーブル名, 自分のidのカラム名, 相手のidのカラム名);
     *
     * sql: select * from `users` inner join `user_follow` on `users`.`id` = `user_follow`.`user_id` where `user_follow`.`follow_id` = ?;
     * 1. select * from `users` inner join `user_follow` on `users`.`id` = `user_follow`.`user_id; = 全ユーザーからフォローされているユーザー一覧を取得
     * 2.  where `user_follow`.`follow_id` = ?'; 自分をフォローしているユーザーに絞り込み
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        //var_dump($this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->toSql());
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function follow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id === $userId;

        if ($exist || $its_me) {
            return false;
        } else {
            $this->followings()->attach($userId);
            return true;
        }
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function unFollow($userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id === $userId;

        if ($exist && !$its_me) {
            $this->followings()->detach($userId);
            return true;
        }

        return false;
    }

    /**
     * sql: select * from "users" inner join "user_follow" on "users"."id" = "user_follow"."user_id" where "user_follow"."follow_id" = ? and "user_id" = ?
     * @param int $userId
     * @return bool
     */
    public function is_following($userId)
    {
        //var_dump($this->followers()->where('user_id', $userId)->toSql());
        return $this->followers()->where('user_id', $userId)->exists();
    }

    /**
     * sql: select * from "microposts" where "user_id" in (?, ?, ?, ?)
     * @return \Illuminate\Database\Query\Builder
     */
    public function feed_microposts()
    {
        $userIds = $this->followings()->pluck('users.id')->toArray();
        $userIds[] = $this->id;
        return Micropost::whereIn('user_id', $userIds);
    }

    /**
     * 以下最終課題追加
     */
    /**
     * belongsToMany(関連づけるモデル名, 使用する中間テーブル名, 中間テーブルに保存されている自分のidのカラム名, 中間テーブルに保存されている関係先のidのカラム名);
     *
     * sql: select * from "microposts" inner join "favorites" on "microposts"."id" = "favorites"."micropost_id" where "favorites"."user_id" = ?
     * @link https://techacademy.jp/my/php/laravel6/twitter-clone#chapter-10-1 belongsToMany()に記載
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        //var_dump($this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')->toSql());
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')
            ->withTimestamps();
    }

    /**
     * @param int $micropostId
     * @return bool
     */
    public function favorite($micropostId)
    {
        if (!$this->is_favorite($micropostId)) {
            $this->favorites()->attach($micropostId);
            return true;
        }

        return false;
    }

    /**
     * @param int $micropostId
     * @return bool
     */
    public function unFavorite($micropostId)
    {
        if ($this->is_favorite($micropostId)) {
            $this->favorites()->detach($micropostId);
            return true;
        }

        return false;
    }

    /**
     * @param int $micropostId
     * @return bool
     */
    public function is_favorite($micropostId)
    {
        return $this->favorites()->where('micropost_id', $micropostId)->exists();
    }
}
