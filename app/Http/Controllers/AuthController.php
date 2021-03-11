<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Responses\Auth\FailResponse;
use App\Http\Responses\Auth\SuccessResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @throws \Exception
     */
    public function login(Request $request)
    {
        $user = User::query()
            ->where('email', $request->json('email'))
            ->first()
        ;

        if (empty($user)) {
            return new FailResponse();
        }

        if (!Hash::check($request->json('password'), $user->password)) {
            return new FailResponse();
        }

        return new SuccessResponse($user);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        /**
         * @var User
         */
        $user = new User([
            'name'     => $request->json('name'),
            'email'    => $request->json('email'),
            'password' => Hash::make($request->json('password')),
            'token'    => Str::random(60)
        ]);

        $user->save();

        return response()->json([
            'success' => true,
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'token' => $user->token
            ]
        ]);
    }
}
