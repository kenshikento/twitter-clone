<?php

namespace App\Tweets\Entity;

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
        'id','indices_id', 'entity_id', 'text'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden   = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * 
     * @return boolean [description]
     */
    public function indices() : HasMany
    {
        return $this->hasMany(Indices::class);
    }

    public function entity() : BelongsTo
    {
        return $this->belongTo(Entity::class);
    }
}
