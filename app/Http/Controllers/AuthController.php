<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param Request $request
     *
     * @return ResponseFactory|Response
     */
    public function register(Request $request): Response|ResponseFactory
    {
        $validatedData = $request->validate(
            [
                'name'     => 'required|max:55',
                'email'    => 'email|required|unique:users',
                'password' => 'required|confirmed',
            ]
        );

        $validatedData['password'] = Hash::make($validatedData['password']);

        /** @var User $user */
        $user = User::factory()->createOne($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(
            [
                'user'         => $user,
                'access_token' => $accessToken,
            ],
            Response::HTTP_CREATED
        );
    }


    /**
     * Login an user.
     *
     * @param Request $request
     *
     * @return ResponseFactory|Response
     */
    public function login(Request $request): Response|ResponseFactory
    {
        $loginData = $request->validate(
            [
                'email'    => 'email|required',
                'password' => 'required',
            ]
        );

        $auth = auth();

        if (!$auth->attempt($loginData)) {
            return response(
                [
                    'message' => 'Invalid email and/or password',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        /** @var User $user */
        $user        = $auth->user();
        $accessToken = $user->createToken('authToken')->accessToken;

        return response(
            [
                'user'         => $user,
                'access_token' => $accessToken,
            ]
        );
    }

}
