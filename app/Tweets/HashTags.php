<?php

namespace App\Tweets;

use App\Tweets\Entity;
use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class HashTags extends Model 
{
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

    public function hasTags() : HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function entity() : BelongsTo
    {
        return $this->belongTo(Entity::class);
    }
}
