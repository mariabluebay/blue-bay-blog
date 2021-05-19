<?php

namespace App\Traits;
use App\User;

trait Followable {
    /**
     * adds pending request
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function follow(User $user)
    {
        return $this->follows()->save($user);
    }

    /**
     * deletes the request
     *
     * @param User $user
     * @return int
     */
    public function unfollow(User $user)
    {
        return $this->follows()->detach($user);
    }

    /**
     * remove or add a pending request
     *
     * @param User $user
     * @return array|array[]
     * @throws \Exception
     */
    public function toggleFollow(User $user)
    {
        cache()->forget('friends');
        return $this->follows()->toggle($user);
    }

    /**
     * existance of a request
     * @param $user
     * @return bool
     */
    public function following($user)
    {
        return (bool) $this->follows()
                            ->where('following_user_id', $user instanceof User ? $user->id : $user)
                            ->exists();
    }

    /**
     * requests initiated
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id')
                    ->withTimestamps();
    }

    /**
     * requests recieved
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_user_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * number of account the current user is following
     *
     * @return int
     */
    public function getFollowsCountAttribute()
    {
        return $this->follows()->count();
    }

    /**
     * number of followers
     * @return int
     */
    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

    /**
     * check the relation between users
     *
     * @return bool
     */
    public function getIsFollowedAttribute()
    {
        $res = (bool)$this->followers()
            ->where('user_id', auth()->id())
            ->exists();
        if(!$res){
            $res = auth()->user()->following($this);
        }
        return $res;
    }

    /**
     * friendship request sent by this user
     */
    protected function friendsOfThisUser()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id')
            ->withPivot('status')
            ->wherePivot('status', 'confirmed');
    }
    /**
     * frienship requests received by this user
     */
    protected function thisUserFriendOf()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_user_id', 'user_id')
            ->withPivot('status')
            ->wherePivot('status', 'confirmed');
    }

    /**
     * confirmed friend requests
     *
     * @return mixed
     */
    public function getFriendsAttribute()
    {
        if($temp = $this->friendsOfThisUser)
            return $temp->merge($this->thisUserFriendOf);
        else
            return $this->thisUserFriendOf;
    }

    /***
     * friendship that his user started but now blocked
     */
    protected function blocked_users()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id')
            ->withPivot('status')
            ->wherePivot('status', 'blocked');
    }

    /***
     * friendship that his user started but now blocked
     */
    protected function blocked_friendship_requests()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_user_id', 'user_id')
            ->withPivot('status')
            ->wherePivot('status', 'blocked');
    }

    /**
     * list of usernames for blocked users
     * @return mixed
     */
    protected function getBlockedUserAttribute()
    {
        if( $temp = $this->blocked_users )
            return $temp->merge($this->blocked_friendship_requests)->pluck('username');
        else
            return $this->blocked_friendship_requests->pluck('username');
    }

    /**
     * pending friend request
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected function friend_request_received()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_user_id', 'user_id')
        ->withPivot('status')
        ->wherePivot('status', 'pending');
    }
}
