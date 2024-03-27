<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

class BaseController extends Controller
{
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
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    // just checking the github

    //just pushing from the github
}
