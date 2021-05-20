<?php

namespace App\Http\Controllers;

use App\Follow;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\DB;

class FollowsController extends Controller
{
    /**
     * handles sending a friend request
     *
     * @param User $user
     * @return UserResource
     */
    public function store(User $user)
    {
        auth()->user()->toggleFollow($user);
        return new UserResource($user);
    }

    /**
     * sets the friendship status to blocked
     *
     * @param User $user
     * @return int
     */
    public function block(User $user)
    {

        $int = DB::table('follows')
            ->whereIn('user_id', [ auth()->id(), $user->id])
            ->whereIn('following_user_id', [auth()->id(), $user->id ])
            ->whereIn('status', ['pending', 'confirmed'])
            ->update(['status' => 'blocked']);

        if( !$int ) {
            $int = Follow::create([
                'status' => 'blocked',
                'user_id' => auth()->id(),
                'following_user_id' =>$user->id
            ]);
        }

        return $int;
    }

    /**
     * sets the friendship status to confirmed
     *
     * @param User $user
     * @return int
     */
    public function accept(User $user)
    {

        $int = DB::table('follows')
            ->whereIn('user_id', [ auth()->id(), $user->id])
            ->whereIn('following_user_id', [auth()->id(), $user->id ])
            ->where('status', 'pending')
            ->update(['status' => 'confirmed']);

        return $int;
    }

    /**
     * Delete the friend request
     *
     * @param User $user
     * @return int
     */
    public function decline(User $user)
    {

        $int = DB::table('follows')
            ->whereIn('user_id', [ auth()->id(), $user->id])
            ->whereIn('following_user_id', [auth()->id(), $user->id ])
            ->delete();

        return $int;
    }
}
