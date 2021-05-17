<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->with('posts')->firstOrFail();
        return new UserResource($user->loadMissing(['posts']));
    }

}
