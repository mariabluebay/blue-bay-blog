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
            'friends_count' => count($this->confirmedFriends),
            'avatar' => $this->avatar_url,
            'cover' => $this->cover_url,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'friends' => $this->confirmedFriends,
            'pending_friend_request' => $this->pendingFriendRequests,
            'posts_count' => $this->posts_count,
            'blocked_users' => $this->blockedUser,
            'is_followed' => $this->is_followed,
            'follows' => $this->pendingFriendRequestsSent
        ];
    }
}
