<?php

namespace App;

use App\Http\Resources\Friend as FriendResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
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
        return FriendResource::collection($this->friend_request_received);
    }

    public function getConfirmedFriendsAttribute(){
        return FriendResource::collection($this->friends);
    }

    public function getPendingFriendRequestsSentAttribute(){
        return FriendResource::collection($this->friend_request_sent);
    }

    public function getAvatarUrlAttribute() {
        $avatar = URL::to('/') . '/images/avatar.svg';

        if( !is_null( $this->avatar ) && !empty( $this->avatar ) ) {
            $avatar = URL::to('/') . Storage::url('profiles/'. $this->username.'/avatar/' . $this->avatar);
        }

        return $avatar;
    }

    public function getCoverUrlAttribute() {
        $cover = URL::to('/') . '/images/cover.jpg';

        if( !is_null( $this->cover ) && !empty( $this->cover ) ){
            $cover = URL::to('/') . Storage::url('profiles/' .$this->username.'/cover/' . $this->cover);
        }

        return $cover;
    }

    public function getFriendshipStatusAttribute(){
        return DB::table('follows')
            ->whereIn('user_id', [ auth()->id(), $this->id])
            ->whereIn('following_user_id', [auth()->id(), $this->id ])
            ->value('status');
    }
}
