<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


use App\Http\Requests\Auth\{
    Login,
    Logout,
    Register,
    User as AuthUser,
};
use App\Http\Resources\{DefaultErrorResource, DefaultResource};
use App\Repositories\AuthRepository;
use App\Utils\HttpStatusCodeUtils;

class AuthController extends Controller
{
    // Protected items context
    protected $model;

    /**
     * Constructor method
     * @param AuthRepository $model
     */
    public function __construct(AuthRepository $model)
    {
        $this->model = $model;
    }

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Register $request)
    {
        $object = $this->model->create($request->inputs);

        return (new DefaultResource($object))->response()->setStatusCode(HttpStatusCodeUtils::CREATED);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Login $request)
    {
        if (!Auth::attempt($request->credentials)) {
            return response()->json([
                'message' => 'You are unauthorized'
            ], HttpStatusCodeUtils::UNAUTHORIZED);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = $request->token_expires_at;
        }

        $token->save();

        $object = [
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => $tokenResult->token->expires_at,
        ];

        return (new DefaultResource($object))->response()->setStatusCode(HttpStatusCodeUtils::OK);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Logout $request)
    {
        $request->user()->token()->revoke();
        $object = ['message' => 'Successfully logged out'];

        return (new DefaultResource($object))->response()->setStatusCode(HttpStatusCodeUtils::OK);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(AuthUser $request)
    {
        $object = $request->user();

        return (new DefaultResource($object))->response()->setStatusCode(HttpStatusCodeUtils::OK);
    }
}
