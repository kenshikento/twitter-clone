<?php

namespace App\Tweets\Entity;

use App\Tweets\Entity;
use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Urls extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'entity_id', 'url', 'expanded_url', 'display_url'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urls';

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
        'indices' => 'array',
        'unwound' => 'array',
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
