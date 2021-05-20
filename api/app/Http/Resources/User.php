<?php

namespace App\Http\Resources;

use App\Http\Resources\Post as PostResource;
use App\Http\Resources\Friend as FriendResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'username' => $this->username,
            'name' => $this->name,
            'about' => $this->about,
            'email' => $this->email,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'friends_count' => count($this->confirmed_friends),
            'avatar' => $this->avatar_url,
            'cover' => $this->cover_url,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'friends' => $this->confirmedFriends,
            'pending_friend_request' => $this->pending_friend_requests,
            'posts_count' => $this->posts_count,
            'blocked_users' => $this->blocked_user,
            'is_followed' => $this->is_followed,
            'follows' => $this->pending_friend_requests_sent
        ];
    }
}
