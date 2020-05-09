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

    public function getResponse()
    {
        $this->user = $this->user()->first();
        $this->entity = $this->entity()->first();
        $this->entity->urls = $this->entity->urls()->get();

        $hashtag = $this->entity->getHashTagCollection();
        
        if ($hashtag) {
            $this->entity->hashtag = $hashtag;
        }

        $userMentions = $this->entity->getUserMentionCollection();

        if (count($userMentions) > 0) {
            $this->entity->user_mentions = $userMentions;
        }

        $media = $this->entity->getMediaCollection();

        if (count($media) > 0) {
            $this->entity->media = $media;
        }

        $symbol = $this->entity->getSymbolCollection();

        if (count($symbol) > 0) {
            $this->entity->symbols = $symbol;
        }

        $poll = $this->entity->getPollCollection();
        
        if (count($poll) >= 1) {
            $this->entity->polls = $poll;
        }

        return $this;
    }
}
