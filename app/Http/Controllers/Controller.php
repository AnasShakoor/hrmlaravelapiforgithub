<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Your API",
 *     version="1.0.0",
 *     description="API documentation for Your Laravel application",
 *
 *     @OA\Contact(
 *         email="your@email.com",
 *         name="Your Name"
 *     ),
 *
 *     @OA\License(
 *         name="Your License",
 *         url="http://your-license-url.com"
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
