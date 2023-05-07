<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\Repository\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public $userRepository;

    /**
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $loginRequest)
    {
        try {
            $result = $this->userRepository->loginUser($loginRequest->email, $loginRequest->password);

            return response()->json([
                'message'        => $result['message'],
                'token'           => $result['token'],
                'roles'           => $result['roles'],
                'profileInfo'       => $result['profileInfo'],
                'permissions'     => $result['permissionNames']
            ], $result['status']);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Internal Server Error',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        return response()->json([
            'message'        => 'User logged',
            'user'           => $user,
        ]);
    }


    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if (!empty(Auth::guard('sanctum')->user()->tokens) and count(Auth::guard('sanctum')->user()->tokens)) {
            Auth::guard('sanctum')->user()->tokens()->delete();
        }

        return response()->json([
            'message'        => 'Token revoked',
        ]);
    }
}
