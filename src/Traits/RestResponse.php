<?php

namespace GoApptiv\FileManagement\Traits;

use Illuminate\Http\Response as ResponseConstants;

trait RestResponse
{
    /**
     * Success Response
     *
     * @param $data
     *
     * @return $mixed
     */
    protected function success($data)
    {
        return collect(
            [
                'status' => true,
                'data' => $data
            ]
        );
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
        return collect(
            [
                'status' => false,
                'errors' => $errors
            ]
        );
    }

    /**
     * No route found response
     *
     * @return JsonResponse
     */
    public static function notFound()
    {
        return collect(
            [
                'status' => false,
                'errors' => ['message' => "Not found"]
            ]
        );
    }

    /**
     * No Permission Response
     *
     * @return JsonResponse
     */
    public static function noPermission()
    {
        return collect(
            [
                'status' => false,
                'errors' => ['message' => "Permission denied"]
            ]
        );
    }

    /**
     * Server Error response
     *
     * @return JsonResponse
     */
    public static function serverError()
    {
        return collect(
            [
                'status' => false,
                'errors' => ['message' => "Request failed"]
            ]
        );
    }
}
