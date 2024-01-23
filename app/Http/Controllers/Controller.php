<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="OpenApi Documentation",
 *      description="Документация для task-api",
 *      @OA\Contact(
 *           email=L5_SWAGGER_CONST_EMAIL
 *       )
 * )
 *
 * @OA\PathItem(path="/api")
 *
 * @OA\Server(
 *       url=L5_SWAGGER_CONST_HOST,
 *       description="Основной API"
 *  )
 *
 * @OA\Tag(
 *      name="auth",
 *      description="authorize",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
