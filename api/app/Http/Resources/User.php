<?php

namespace App\Http\Resources;

use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
        $avatar = URL::to('/') . '/images/avatar.svg';
        $cover = URL::to('/') . '/images/cover.jpg';

        if( !is_null( $this->avatar ) && !empty( $this->avatar ) ){
            $avatar = URL::to('/') . Storage::url('profiles/'. $this->username.'/avatar/' . $this->avatar);
        }

        if( !is_null( $this->cover ) && !empty( $this->cover ) ){
            $cover = URL::to('/') . Storage::url('profiles/' .$this->username.'/cover/' . $this->cover);
        }

        return [
            'username' => $this->username,
            'name' => $this->name,
            'about' => $this->about,
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
            'posts_count' => $this->posts_count,
        ];
    }
}
