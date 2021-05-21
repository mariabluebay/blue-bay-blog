<?php

namespace App\Http\Resources;

use App\Http\Resources\Author as AuthorResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $published_at = null;

        if( !is_null( $this->published_at ) || !empty( $this->published_at ) ){
            $published_at =  Carbon::createFromFormat('Y-m-d H:i:s', $this->published_at)->diffForHumans();
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'featured' => $this->featured_url,
            'active' => $this->active,
            'body' => $this->body,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'published_at' => $published_at,
            'author' => new AuthorResource($this->whenLoaded('author')),
            'audience' => $this->audience
        ];
    }
}
