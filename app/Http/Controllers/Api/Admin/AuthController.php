<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Transformers\UserTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
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
        $user = $request->user();
        $transformer = new UserTransformer();
        $auth = $request->header('Authorization');

        return $this->response([
            'user' => $transformer->transform($user),
            'token' => [
                'token_type' => 'Bearer',
                'access_token' => explode(' ', $auth)[1],
            ],
        ], 200);
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

        $user = Auth::user();
        $transformer = new UserTransformer();

        return $this->response([
            'user' => $transformer->transform($user),
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
