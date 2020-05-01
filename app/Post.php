<?php

namespace App;

use App\Comments;
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
     * Relationship for entities
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    /*public function entities() : HasOne
    {
        return $this->hasOne(Entity::class);
    }*/
}