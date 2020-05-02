<?php

namespace App\Tweets;

use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Entity extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'post_id', 'name', 'email', 'screen_name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden   = [
        'id','created_at', 'updated_at', 'password'
    ];

    public $incrementing = false;

    public function hasTags() : HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function posts() : BelongsTo
    {
        return $this->belongTo(Post::class);
    }
}
