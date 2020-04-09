<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Http\Controllers\Api\ApiController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends ApiController
{
    protected $jwtAuth;

    public function  __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    /**
     * 
     */
    public function getUser(Request $request)
    {
        return $this->response($request->user());
    }

    /**
     * 
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->response($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');
        if (!$token = $this->jwtAuth->attempt($credentials)) {
            return $this->response(['errors' => ['message' => trans('auth.failed')]], 400);
        }

        return $this->response([
            'token' => [
                'token_type' => 'Bearer',
                'access_token' => $token,
            ],
        ], 200);
    }

    /**
     * 
     */
    public function logout(Request $request)
    {
        if ($token = $this->jwtAuth->getToken()) {
            $this->jwtAuth->invalidate($token);
            return $this->response(['message' => trans('auth.logout.success')], 200);
        }

        return $this->response(['errors' => ['message' => trans('auth.logout.warning')]], 400);
    }

    /**
     * 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->response($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        return $this->response([
            'user' => $user,
            'token' => [
                'token_type' => 'Bearer',
                'access_token' => $this->jwtAuth->fromUser($user),
            ],
        ], 201);
    }
}
