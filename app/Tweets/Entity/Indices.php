<?php

namespace App\Tweets\Entity;

use App\Tweets\HashTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Indices extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'indices', 'hastag_id'
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
     * Relationship to hasTags
     * @return BelongsTo
     */
    public function hasTags() : BelongsTo
    {
        return $this->belongTo(HashTags::class);
    }
}
