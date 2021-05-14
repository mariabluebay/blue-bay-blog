<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request\User\RegistrationRequest;
use Illuminate\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request)
    {

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return abort(401);
        }
        return $this->response(new UserResource($user), $token);
    }

    protected function response(UserResource $data, $token){

        return  $data->additional([
            'meta' => [
                'token' => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }
}
