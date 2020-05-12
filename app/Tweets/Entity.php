<?php

namespace App\Tweets;

use App\Post;
use App\Tweets\Entity\HashTags;
use App\Tweets\Entity\Media;
use App\Tweets\Entity\Symbol;
use App\Tweets\Entity\Urls;
use App\Tweets\Entity\UserMention;
use Illuminate\Database\Eloquent\Collection;
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
        'created_at', 'updated_at'
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

    /**
     * Grabs Poll collection and formats the data 
     * @return $poll Collection
     */
    public function getPollCollection() : Collection
    {   
        $poll = $this->polls()->get();

        $poll->each(function ($item, $key) {
            if ($item->indices) {
                $item->indices = $item->parseIndices();    
            }             
        });

        return $poll;
    }

    /**
     * Grabs Symbol collection and formats the data 
     * @return $symbol Collection
     */
    public function getSymbolCollection() : Collection
    {
        $symbol = $this->symbols()->get();

        if (count($symbol) > 0) {
            // Should ideally add this on user mention media
            $symbol->each(function ($item, $key) {
                $item->indices = $item->parseIndices();
            });

            return $symbol;
        }
    }

    /**
     * Grabs Media collection and formats the data 
     * @return $media Collection
     */
    public function getMediaCollection() : Collection 
    {
        $media = $this->media()->get();

        if (count($media) > 0) {
            // Should ideally add this on user mention media
            $media->each(function ($item, $key) {
                $item->indices = $item->parseIndices();
                $item->sizes   = json_decode($item->sizes);
            });

            return $media;
        }
    }

    /**
     * Grabs User Mention collection and formats the data 
     * @return $media Collection
     */
    public function getUserMentionCollection() : Collection
    {
        $userMentions = $this->userMentions()->get();

        if (count($userMentions) > 0) {
            $userMentions->each(function ($item, $key) {
                if ($item->user()->first()) {
                    $user = $item->user()->first();
                    $item->screen_name = $user->screen_name;
                    $item->id = $user->id;
                    $item->id_str = $user->id_str;
                    $item->name = $user->name;
                }
            });

            return $userMentions;
        }
    }

    /**
     * Grabs HashTags  and formats the data 
     */
    public function getHashTagCollection()
    {
        $hashtag = $this->hashTags()->first();

        if ($hashtag) {
            $hashtag->indices = $hashtag->parseIndices();
        }

        return $hashtag;
    }    
}
