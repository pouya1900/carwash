<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * make json responses
 *
 * Trait ResponseUtilsTrait
 * @package App\Traits
 */
trait ResponseUtilsTrait
{
    /**
     * send a success json message
     *
     * @param string $message
     * @return JsonResponse
     */
    public function sendError(string $message = ''): JsonResponse
    {
        $message = $message ?? trans('apiMessages.response.failed');
        $httpCode = 200;
        $status = 1;

        $result = [
            'status'  => $status,
            'message' => strval($message),
        ];

        return response()->json(
            $result,
            $httpCode,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * send an error json message
     *
     * @param array $data
     * @param string $message
     * @return JsonResponse
     */
    public function sendResponse(array $data = [], string $message = ''): JsonResponse
    {
        $message = $message ?? trans('apiMessages.response.success');
        $httpCode = 200;
        $status = 0;

        $result = [
            'status'  => $status,
            'message' => strval($message),
            'data'    => $data,
        ];

        return response()->json(
            $result,
            $httpCode,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

}
