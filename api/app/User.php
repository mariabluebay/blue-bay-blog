<?php

namespace App;

use App\Http\Resources\Friend as FriendResource;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Followable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, Followable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Returns all users posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id')
                    ->latest();
    }

    public function getPostsCountAttribute()
    {
        return $this->posts()->count();
    }

    public function getPendingFriendRequestsAttribute(){
        $list = [];

        $solicitors = $this->friend_request_received->pluck('username');

        if( count($solicitors) > 0 ) {
            $list = FriendResource::collection(
                User::whereIn('username', $solicitors)->get()
            );
        }

        return $list;
    }

    public function getConfirmedFriendsAttribute(){
        $list = [];

        $friends = $this->friends->pluck('username');

        if( count($friends) > 0 ) {
            $list = FriendResource::collection(
                User::whereIn('username', $friends)->get()
            );
        }

        return $list;
    }
}
