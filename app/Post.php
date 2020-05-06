<?php

namespace App;

use App\Comments;
use App\Tweets\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'id_str', 'user_id', 'title', 'content',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden   = [
        'updated_at', 'password', 'user_id', 'id'
    ];

    public $incrementing = false;

    /**
     * Relationship for Comments
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Comments::class);
    }

        /**
     * Relationship for post
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship for entity
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entity() : HasOne
    {
        return $this->hasOne(Entity::class);
    }

    public function urls() : HasMany
    {
        return $this->hasMany(Urls::class);
    }

    public function getJsonResponse()  
    {
        $this->user = $this->user()->first();
        $this->entity = $this->entity()->first();
        $this->entity->urls = $this->entity->urls()->get();

        $hashtag = $this->entity->hashTags()->first();
        $this->entity->hashtag = $hashtag;

        if ($hashtag) {    
            $this->entity->hashtag->indices = $hashtag->parseIndices();
        }

        $userMentions = $this->entity->userMentions()->get();

        if (count($userMentions) > 0) {
            // Should ideally add this on user mention model 
            $userMentions->each(function ($item, $key) {
                if ($item->user()->first()) {
                    $user = $item->user()->first();
                    $item->screen_name = $user->screen_name;
                    $item->id = $user->id;
                    $item->id_str = $user->id_str;
                    $item->name = $user->name;
                }
            });

            $this->entity->user_mentions = $userMentions;
        }

        $media = $this->entity->media()->get();

        if (count($media) > 0) {
            
            // Should ideally add this on user mention media 
            $media->each(function ($item, $key) {
                $item->indices = $item->parseIndices();
                $item->sizes   = json_decode($item->sizes);
            });

            $this->entity->media = $media;
        }


        // Symbol
        
        // Poll
        
        return $this;
    }
}
