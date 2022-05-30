<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class UserController
{
    public function tokenUser()
    {
        $user = User::find(1);
        $token = $user->createToken('toke_test');
        //$token = $user->createToken('token-name', ['post:create']);
        return new JsonResponse(
            data: ['token' => $token->plainTextToken],
        );
    }


    #[OA\Post(
        path: '/users/auth-token',
        summary: "User Login",
        tags: ['Authorize'],
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "email",
                    format: "string",
                    default: "schuster.montana@example.com"
                ),
                new OA\Property(
                    property: "password",
                    format: 'string',
                    default: 'password',
                ),
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'success',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "token",
                    description: "token",
                    format: "string",
                    default: '8|A3Id3nWYcxjGO2b30L0EknKT6999KRWme051zHpN'
                ),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(
        response: 401,
        description: 'Fail',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "message",
                    type: "string",
                    default: 'Unauthenticated'
                ),
            ],
        )
    )]
    public function tokenUserAuth(Request $request): JsonResponse
    {

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user &&
            Hash::check($request->password, $user->password)) {
            $token = $user->createToken('token_test');
            return new JsonResponse(
                data: ['token' => $token->plainTextToken],
            );
        }

        return new JsonResponse(
            data: ['error' => 'The provided credentials do not match our records.'],
            status: 401,
        );

    }
}

