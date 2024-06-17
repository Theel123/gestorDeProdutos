<?php

namespace App\Http\Controllers\Api;

use App\Responses\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomerExceptions;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
      * @OA\Post(
      *     tags={"Auth"},
      *     summary="Return a customer logged with jwt token",
      *     description="Return a customer logged with jwt token",
      *     path="/api/v1/login/",
      *    @OA\Parameter(
      *         description="Customer Email",
      *         in="query",
      *         name="email",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Parameter(
      *         description="Customer Password",
      *         in="query",
      *         name="password",
      *         required=true,
      *         @OA\Schema(type="string"),
      *     ),
      *     @OA\Response(response="200", description="Customer Logged"),
      * ),
      *
     */

    public function login(): JsonResponse
    {
        try {
            $credentials = request(['email', 'password']);

            if (empty($credentials['email']) || empty($credentials['password'])) {
                throw CustomerExceptions::missingFields();
            }

            $token = auth()->attempt($credentials);

            if (!$token) {
                throw CustomerExceptions::unauthorized();
            }

            return $this->successJsonResponse(
                Response::HTTP_OK,
                'Login Realizado com sucesso',
                $token
            );
        } catch (\Exception $e) {
            return $this->errorJsonResponse(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     summary="Return a customer logged out",
     *     description="Return a customer logged logged out",
     *     path="/api/v1/logout/",
     *     security={{"token": {}}},
     *     @OA\Response(response="200", description="Customer Logged Out "),
     * ),
     *
    */

    public function logout(): JsonResponse
    {
        try {
            auth()->invalidate();

            return $this->successJsonResponse(
                Response::HTTP_OK,
                'Logout realizado com sucesso.'
            );
        } catch (JWTException $e) {
            return $this->errorJsonResponse(
                Response::HTTP_BAD_REQUEST,
                'Ocorreu um erro ao realizar o logoff.'
            );
        }
    }
}
