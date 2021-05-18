<?php

namespace App\Http\Controllers;

use App\Follow;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowsController extends Controller
{
    public function store(User $user)
    {
        auth()->user()->toggleFollow($user);
        return new UserResource($user);
    }

    public function block(User $user)
    {

        $int = DB::table('follows')
            ->whereIn('user_id', [ auth()->id(), $user->id])
            ->whereIn('following_user_id', [auth()->id(), $user->id ])
            ->whereIn('status', ['pending', 'confirmed'])
            ->update(['status' => 'blocked']);

        if(!$int){
            $int = Follow::create([
                'status' => 'blocked',
                'user_id' => auth()->id(),
                'following_user_id' =>$user->id
            ]);
        }

        return $int;
    }
}
