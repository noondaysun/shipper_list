<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/auth/signin",
     *      summary="Log in a user",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          request="AuthSignIn",
     *          description="Sign in for a user",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="email",
     *                  type="string",
     *                  example="test@example.com"
     *              ),
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  example="Right#Password1!"
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="user_id", type="string", example="1"),
     *              @OA\Property(property="access_token", type="string", description="JWT token"),
     *              @OA\Property(property="type", type="string", description="Token type", example="Bearer"),
     *              @OA\Property(property="expires_at", type="datetime", description="Token expiration date", example="2022-03-23T16:43:46+0000"),
     *          ),
     *      ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=422, description="Request has validation errors"),
     *      @OA\Response(response=429, description="Too many requests"),
     * )
     */
    public function signin(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email:rfc',
            'password' => 'required|min:8',
        ]);

        if (! Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            return response()->json(
                [
                    'errors' => [
                        [
                            'status' => Response::HTTP_UNAUTHORIZED,
                            'detail' => 'Could not successfully authenticate. Please try again later.',
                        ],
                    ],
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $user = User::where('email', $request['email'])->first();

        return response()->json([
            'user_id' => $user->id,
            'access_token' => ($user->createToken('authToken'))->plainTextToken,
            'type' => 'Bearer',
            'expires_at' => (new DateTime())->add(new DateInterval('PT120M'))->format(DateTime::ISO8601),
        ]);
    }
}
