<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the Post model
 * @package App
 */
class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'featured',
        'title',
        'slug',
        'excerpt',
        'body',
        'active',
        'author_id'
    ];

    /**
     * Get the user relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
