<?php

namespace App;

use App\Post;
use App\Tweets\Entity\UserMention;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','id_str','name', 'email', 'screen_name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden   = [
        'created_at', 'updated_at', 'password'
    ];

    public $incrementing = false;

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function userMentions() : HasMany
    {
        return $this->hasMany(UserMention::class);
    }
}
