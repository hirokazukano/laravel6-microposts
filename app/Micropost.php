<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Micropost
 *
 * @property int $id
 * @property int $user_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Micropost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Micropost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Micropost query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Micropost whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Micropost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Micropost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Micropost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Micropost whereUserId($value)
 * @mixin \Eloquent
 */
class Micropost extends Model
{
    public $fillable = ['content'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorite_users()
    {
        return $this->belongsToMany(User::class);
    }
}
