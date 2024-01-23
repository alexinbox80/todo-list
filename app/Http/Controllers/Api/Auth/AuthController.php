<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Contracts\ResponseContract as ResponseService;

class AuthController extends Controller
{
    /**
     * Login api
     *
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     operationId="login",
     *     tags={"auth"},
     *     description="Авторизация пользователя",
     *     @OA\Parameter(
     *          name="email",
     *          description="email пользователя",
     *          required=true,
     *          in="query",
     *           @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="Пароль пользователя",
     *          required=true,
     *          in="query",
     *           @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *     @OA\Response(response="200",
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                    property="status",
     *                    description="status",
     *                    format="boolean",
     *                    example=true
     *                 ),
     *               @OA\Property(
     *                          property="errors",
     *                          type="object",
     *                      ),
     *                @OA\Property(
     *                    property="data",
     *                    description="data",
     *                    format="object",
     *                       @OA\Property(
     *                          property="token",
     *                          description="token",
     *                          format="string",
     *                          example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiZmJkMTJmNzJkYjRkMmY4M2RiYzZkNGNkNDFiNWMwYTJkMDU5NjM5NWY5Y2I5YWUyZWI2YzQzYTIwNWY4ZGQyMzRhZDBjMzA2OWIxN2I1N2YiLCJpYXQiOjE2ODQxMjgwNDMuODQ2ODU1LCJuYmYiOjE2ODQxMjgwNDMuODQ2ODU4LCJleHAiOjE3MTU3NTA0NDMuODM4OTc4LCJzdWIiOiIxMiIsInNjb3BlcyI6W119.KDXv0MMfi3P97L8KXFoHO62dT6chg_4kOgT49DLpD5Lc5UG_YOangQZuURIxVgKIiE3tZwPgV4MuID4u4FgyopFRaRWGazjwIkjHGywpI_e7dzF6FOck8ePeUUBXlybsLpThzzPRKbYmq5Wxnv-hbx6-doGx9CCjw9TRexjRRuqWLv6d0ZpIPIyzbHbG3cZcSAgms0JMN6WLBuJNkdW2kFuhbC9uMu5KhOK1MdX4vULb1XcZJpRx2gjac6B8l79sH8y1pt6beGljUyzwTKTx1B2Onm5LJZ6ipcXMwuoR2MZY1YbihLbMqTATuCTCpBFlMzXi9vwE1GbJIt-wDJff33Y2C7Iq1AN-RMNjFKlckd-SYNwdT5CFOvWVV5UOG0sIdXNZayZ7fDAi3wSm7C8s9PiJkDvh-f1g7VFl4pmTN3DONMZQemkOtnBQuqfjbMz0GghdzdDA64PjMZrZbw5qi7NB21bQIy4ilh5xDT9Ai0dzV2KUdj9bfONgE_LgDWCy005cuwvuRoMckQiRpJH6jw8Qez0cu0HQ7TJksCUmtbzD6zS0GblrYJ9CozjMMMMXB2tnTXZy3BJ_lZVmDJmbiUq-O1radHkuE_Ou9XQCc0IN6iqa701cFxxjzmU_cK39OWv2RDu7S7bOeARwk71ZR_co2j5_b3D9cMjpy2rpjcw"
     *                       ),
     *                 ),
     *              ),
     *          ),
     *      ),
     * )
     *
     * @param LoginRequest $request
     * @param ResponseService $responseService
     * @return JsonResponse
     */
    public function login(LoginRequest $request, ResponseService $responseService): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('tasks')->accessToken;
            return $responseService->success($success);
        } else {
            return $responseService->unprocessableContent(['message' => __('auth.failed')]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     operationId="logoutUser",
     *     tags={"auth"},
     *     description="Выход из аккаунта. Нужно передавать персональный токен пользователя",
     *       security = {
     *      {"apiKey": {}},
     *     },
     *     @OA\Response(response="200",
     *          description="LoggedOut",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                 @OA\Property(
     *                    property="message",
     *                    description="message",
     *                    format="string",
     *                    example="Logged out"
     *                 ),
     *              ),
     *          ),
     *      ),
     * )
     *
     * @param ResponseService $responseService
     * @return JsonResponse
     */
    public function logOutUser(ResponseService $responseService): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $responseService->success(['message' => __('auth.loggedOut')]);
    }
}
