<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function store(User $user)
    {
        auth()->user()->toggleFollow($user);
        return new UserResource($user);
    }
}
