<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *     path = "/api/auth/register",
     *     tags = {"Auth"},
     *     summary = "Register",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"example title",
     *                     "email":"example@example.com",
     *                     "password":123456
     *                }
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *          response = 200,
     *          description = "Register Successfuly",
     *            @OA\JsonContent(
     *              @OA\Property(property="messages",type="string",example="Register Successfuly"),
     *            ),
     *         )
     *     )
     * )
     */


    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->message());
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password'))
        ]);

        if (!$user) {
            return response()->json(['message' => 'Register Failed'], 401);
        }

        return response()->json(['message' => 'Register Successfuly']);
    }



    /**
     * @OA\Post(
     *     path = "/api/auth/login",
     *     tags = {"Auth"},
     *     summary = "Login",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "email":"example@example.com",
     *                     "password":123456
     *                }
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *          response = 200,
     *          description = "Login Successfuly",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token",type="string",example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2NjUxMDkzNDcsImV4cCI6MTY2NTExMjk0NywibmJmIjoxNjY1MTA5MzQ3LCJqdGkiOiJXbFR1U1dTOGZxSTVFWDFYIiwic3ViIjoiNjMzZjg0Mzg0YmM0ZGY3MjE0MDJjYzI0IiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.c9tq4s-w93IH5ovWJM1mwcLBn9Xpi-zGIQRevYQMwAA"),
     *              @OA\Property(property="token_type",type="string",example="bearer"),
     *              @OA\Property(property="expired",type="integer",example=3600),
     *          ),
     *         )
     *     )
     * )
     */

    public function login()
    {
        $credentials = request(['email', 'password']);


        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *     path = "/api/auth/me/{token}",
     *     tags = {"Auth"},
     *     summary = "Get Login Akun Detail",
     *     @OA\Parameter(
     *         in="path",
     *         name="token",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response = 200,
     *          description = "Get Data Successfuly",
     *          @OA\JsonContent(
     *              @OA\Property(property="_id",type="string",example="633f78c918ff2f00d70dab58"),
     *              @OA\Property(property="name",type="string",example="example"),
     *              @OA\Property(property="email",type="string",example="example@example.com"),
     *              @OA\Property(property="created_at",type="string",example="2022-10-07T00:54:33.000000Z"),
     *              @OA\Property(property="updated_at",type="string",example="2022-10-07T00:54:33.000000Z"),
     *            ),
     *         )
     *     )
     * )
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *     path = "/api/auth/logout/{token}",
     *     tags = {"Auth"},
     *     summary = "Logout Account",
     *     @OA\Parameter(
     *         in="path",
     *         name="token",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response = 200,
     *          description = "Register Successfuly",
     *          @OA\JsonContent(
     *              @OA\Property(property="messages",type="string",example="Successfully logged out"),
     *            ),
     *         )
     *     )
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * @OA\Post(
     *     path = "/api/auth/refresh/{token}",
     *     tags = {"Auth"},
     *     summary = "Merefresh Account",
     *     @OA\Parameter(
     *         in="path",
     *         name="token",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response = 200,
     *          description = "Refresh Successfuly",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token",type="string",example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE2NjUxMDkzNDcsImV4cCI6MTY2NTExMjk0NywibmJmIjoxNjY1MTA5MzQ3LCJqdGkiOiJXbFR1U1dTOGZxSTVFWDFYIiwic3ViIjoiNjMzZjg0Mzg0YmM0ZGY3MjE0MDJjYzI0IiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.c9tq4s-w93IH5ovWJM1mwcLBn9Xpi-zGIQRevYQMwAA"),
     *              @OA\Property(property="token_type",type="string",example="bearer"),
     *              @OA\Property(property="expired",type="integer",example=3600),
     *              ),
     *         )
     *     )
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
