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
    /**
     * Creates a new user
     *
     * @param RegistrationRequest $request
     * @return UserResource|void
     */
    public function register(RegistrationRequest $request)
    {
        $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
        ]);

        if (!$token = auth()->attempt($request->only('email', 'password')))
        {
            return abort(401);
        }

        return $this->response(new UserResource($user), $token);
    }

    /**
     * Handle the login request
     *
     * @param LoginRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt( $request->only('email', 'password')))
        {
            return response()->json([
                'errors' => [
                    'email' => 'Invalid login details.'
                ]
            ], 422);
        }

        return $this->response(new UserResource($request->user()), $token);
    }

    /**
     * Returns the authenticated user
     *
     * @param Request $request
     * @return UserResource
     */
    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Handle the logout request
     */
    public function logout()
    {
        Auth::logout();
    }

    /**
     * Adds the token to the response
     *
     * @param UserResource $data
     * @param $token
     * @return UserResource
     */
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
