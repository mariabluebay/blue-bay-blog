<?php

namespace App\Traits;
use App\User;

trait Followable {

    public function follow(User $user)
    {
        return $this->follows()->save($user);
    }

    public function unfollow(User $user)
    {
        return $this->follows()->detach($user);
    }

    public function toggleFollow(User $user)
    {
        cache()->forget('friends');
        return $this->follows()->toggle($user);
    }


    public function following($user)
    {
        return (bool) $this->follows()
                            ->where('following_user_id', $user instanceof User ? $user->id : $user)
                            ->exists();
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id')
                    ->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_user_id', 'user_id')
                    ->withTimestamps();
    }

    public function getFollowsCountAttribute()
    {
        return $this->follows()->count();
    }


    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

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
}
