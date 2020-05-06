<?php

namespace App\Tweets;

use App\Post;
use App\Tweets\Entity\HashTags;
use App\Tweets\Entity\Media;
use App\Tweets\Entity\Symbol;
use App\Tweets\Entity\Urls;
use App\Tweets\Entity\UserMention;
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

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function urls() : HasMany
    {
        return $this->hasMany(Urls::class);
    }

    public function userMentions() : HasMany
    {
        return $this->hasMany(UserMention::class);
    }

    public function media() : HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function symbols() : HasMany
    {
        return $this->hasMany(Symbol::class);
    }

    public function polls() : HasMany
    {
        return $this->hasMany(Symbol::class);
    }    
}
