<?php

namespace App\Tweets;

use App\Post;
use App\Tweets\Entity\HashTags;
use App\Tweets\Entity\Urls;
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
        'id', 'post_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entity';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden   = [
        'id','created_at', 'updated_at'
    ];

    public function hashTags() : HasMany
    {
        return $this->hasMany(HashTags::class);
    }

    public function posts() : BelongsTo
    {
        return $this->belongTo(Post::class);
    }

    public function urls() : HasMany
    {
        return $this->hasMany(Urls::class);
    }
}
