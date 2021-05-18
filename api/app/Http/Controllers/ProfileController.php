<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Requests\User\EditProfileRequest;


class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->with('posts')->firstOrFail();
        return new UserResource( $user->loadMissing(['posts']));
    }

    public function update(EditProfileRequest $request)
    {
        $user = User::findorFail(auth()->id());

        $user->username = $request->get('username', $user->username);
        $user->name = $request->get('name', $user->name);
        $user->about = $request->get('about', $user->aboutcom);
        $user->email = $request->get('email', $user->email);

        if ($request->avatar) {
            $storagePath = $request->avatar->store('profiles/' . $user->username . '/avatar', 'public');
            $user->avatar = basename($storagePath);
        }

        if ($request->cover) {
            $storagePath = $request->cover->store('profiles/' . $user->username . '/cover', 'public');
            $user->cover =  basename($storagePath);
        }

        $user->save();

        return new UserResource($user);
    }


}
