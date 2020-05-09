<?php

namespace App\Tweets\Entity;

use App\Tweets\Entity;
use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Polls extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'entity_id', 'end_datetime' , 'duration_minutes', 'options'
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $cast = [
        'options' => 'array',
    ];

    public function entity() : BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function parseIndices()
    {
        return json_decode($this->indices);
    }
}
