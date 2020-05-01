<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'post_id','user_id' ,'user_str', 'content'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden   = [
        'created_at', 'updated_at'
    ];

    /**
     * Relationship for post
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
