<?php

namespace App\Tweets\Entity;

use App\Tweets\Entity;
use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'entity_id', 'display_url', 'indices', 'id_str', 'media_url', 'media_url_https', 'expanded_url', 'sizes', 'url', 'type'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden   = [
        'id', 'created_at', 'updated_at'
    ];

    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $cast = [
        'indices' => 'array',
        'sizes' => 'array'
    ];

    public function entity() : BelongsTo
    {
        return $this->belongTo(Entity::class);
    }

    public function parseIndices()
    {
        return json_decode($this->indices);
    }
}
