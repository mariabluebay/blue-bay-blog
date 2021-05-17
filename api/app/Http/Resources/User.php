<?php

namespace App\Http\Resources;

use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $avatar = '/images/avatar.svg';
        if( !is_null( $this->avatar ) && !empty( $this->avatar ) ){
            $avatar = Storage::url('profiles/'. $this->username.'/' . $this->avatar);
        }

        $cover = '/images/cover.jpg';
        if( !is_null( $this->cover ) && !empty( $this->cover ) ){
            $cover = Storage::url('profiles/' .$this->username.'/' . $this->cover);
        }

        return [
            //'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'follows_count' => $this->follows_count,
            'followers_count' => $this->followers_count,
            'is_followed' => $this->is_followed,
            'avatar' => $avatar,
            'cover' => $cover,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
    }
}
