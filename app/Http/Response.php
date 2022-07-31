<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;

/**
 * Class Response
 *
 * @package App\Http
 */
final class Response extends JsonResponse
{
    /**
     * Pagination Array
     *
     * @var array
     */
    private array $paginate = [];

    /**
     * Send response message back to client
     *
     * @noinspection ParameterDefaultValueIsNotNullInspection
     * @noinspection PhpMissingParamTypeInspection
     * @param array $data
     * @param null  $status
     *
     * @return JsonResponse
     **/
    public function respond($data = [], $status = null): JsonResponse
    {
        $response['data'] = $data;

        if (!empty($this->paginate)) {
            $response['pagination'] = $this->paginate;
        }

        return response()->json($response, $status ?? $this->getStatusCode());
    }

    /**
     * Set paginate instance
     *
     * @param object $awarePaginator
     *
     * @return $this
     */
    public function paginate(object $awarePaginator): Response
    {
        $this->paginate = [
            'total'        => $awarePaginator->total(),
            'last_page'    => $awarePaginator->lastPage(),
            'per_page'     => $awarePaginator->perPage(),
            'current_page' => $awarePaginator->currentPage()
        ];

        return $this;
    }

    /**
     * Send a created response
     *
     * @param $data
     *
     * @return JsonResponse
     */
    public function created($data): JsonResponse
    {
        return $this->respond($data)->setStatusCode(201);
    }

    /**
     * Send a deleted response
     *
     * @return JsonResponse
     */
    public function deleted(): JsonResponse
    {
        return $this->respond()->setStatusCode(204);
    }

    /**
     * Send the exception message
     *
     * @param      $exception
     * @param null $status
     *
     * @return JsonResponse|object
     */
    public function exception($exception, $status = null)
    {
        // If exception passed is not string, process the exception class.
        if (!is_string($exception)) {
            $exception = $exception::$message;
            $status = $exception::$status;
        }

        return $this->respond(['message' => $exception])->setStatusCode($status ?? $this->getStatusCode());
    }
}
