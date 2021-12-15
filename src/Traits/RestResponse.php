<?php

namespace GoApptiv\FileManagement\Traits;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as ResponseConstants;

trait RestResponse
{
    /**
     * Success Response
     *
     * @param $data
     * @param $code
     *
     * @return $mixed
     */
    protected function success($data, $code = 200)
    {
        return Response::json([
            'status'=> 'Success',
            'data' => $data
        ], $code);
    }

    /**
     * Error Response
     *
     * @param $code
     * @param $errors
     *
     * @return $mixed
     */
    protected function error($code, $errors = null)
    {
        if ($code == ResponseConstants::HTTP_BAD_REQUEST) {
            return $this->badRequest($errors);
        }
        if ($code == ResponseConstants::HTTP_FORBIDDEN) {
            return $this->noContent();
        }
        if ($code == ResponseConstants::HTTP_NOT_FOUND) {
            return $this->notFound();
        }
        if ($code == ResponseConstants::HTTP_INTERNAL_SERVER_ERROR) {
            return $this->serverError();
        }
    }

    /**
     * Handle errors and return Bad Request
     *
     * @param $errors
     * @return JsonResponse
     */
    public static function badRequest($errors)
    {
        return Response::json(
            ['success' => false, 'errors' => $errors],
            ResponseConstants::HTTP_BAD_REQUEST
        );
    }

    /**
     * No route found response
     *
     * @return JsonResponse
     */
    public static function notFound()
    {
        return Response::json(
            [
                'success' => false,
                'errors' => ['message' => 'Not Found']
            ],
            ResponseConstants::HTTP_NOT_FOUND
        );
    }

    /**
     * No Permission Response
     *
     * @return JsonResponse
     */
    public static function noPermission()
    {
        return Response::json(
            [
                'success' => false,
                'errors' => ['message' => 'Permission denied']
            ],
            ResponseConstants::HTTP_FORBIDDEN
        );
    }

    /**
     * Server Error response
     *
     * @return JsonResponse
     */
    public static function serverError()
    {
        return Response::json(
            [
                'success' => false,
                'errors' => ['message' => "Request failed"]
            ],
            ResponseConstants::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
