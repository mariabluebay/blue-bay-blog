<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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
        'author_id',
        'audience'
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

    /**
     * The access relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function audience()
    {
        return $this->morphMany(Access::class, 'accessible');
    }

    /**
     * The audience value
     *
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public function getAudienceAttribute()
    {
        return $this->audience()->first()->accessible_for;
    }

    /**
     * The url to the featured post image
     *
     * @return string
     */
    public function getFeaturedUrlAttribute() {
        $imageUrl = '';

        if(!is_null($this->featured) && !empty( $this->featured )){
            $imageUrl = URL::to('/') . Storage::url('posts/featured/' . $this->featured);
        }

        return $imageUrl;
    }

}
