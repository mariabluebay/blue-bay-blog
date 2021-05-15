<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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
        $imageUrl = '';

        if( !is_null( $this->published_at ) || !empty( $this->published_at ) ){
            $published_at =  Carbon::createFromFormat('Y-m-d H:i:s', $this->published_at)->diffForHumans();
        }

        if(!is_null($this->featured) && !empty( $this->featured )){
            $imageUrl = Storage::url('posts/featured/' . $this->featured);
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'featured' => $imageUrl,
            'active' => $this->active,
            'body' => $this->body,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
            'published_at' => $published_at,
            'author' => $this->author,
            //authors => UserResource::collection($this->posts)
        ];
    }
}
