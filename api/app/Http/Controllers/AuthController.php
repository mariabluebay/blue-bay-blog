<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\User\RegistrationRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\User as UserResource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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

    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' => [
                    'email' => 'Invalid login details.'
                ]
            ], 422);
        }

        return $this->response(new UserResource($request->user()), $token);
    }

    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    public function logout(){
        Auth::logout();
    }

    protected function response(UserResource $data, $token)
    {
        return  $data->additional([
            'meta' => [
                'token' => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }
}
