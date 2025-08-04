<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static where(string $string, mixed $email)
 * @method static create(array $array)
 * @method static find(string $id)
 */
class User extends Authenticatable
{
    protected $guarded = [];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
