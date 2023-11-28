<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasJsonResponse
{
    /**
     * @var int
     */
    protected int $RESPONSE_SUCCESS = 200;

    /**
     * @var int
     */
    protected int $RESPONSE_SERVER_ERROR = 500;

    /**
     * @var int
     */
    protected int $RESPONSE_UNAUTHORIZED = 401;

    /**
     * @var int
     */
    protected int $RESPONSE_NOT_FOUND = 404;

    /**
     * @var int
     */
    protected int $RESPONSE_BAD_REQUEST = 400;

    /**
     * @var int
     */
    protected int $UNAVAILABLE_FOR_LEGAL_REASONS = 451;


    /**
     * @param array $data
     * @param int $code
     * @return Response
     */
    public function json(array $data, int $code = 200): Response
    {
        return response($data, $code);
    }

    /**
     * @param JsonResource $resource
     * @return Response
     */
    public function jsonResource(JsonResource $resource): Response
    {
        return response($resource, $this->RESPONSE_SUCCESS);
    }

    /**
     * @param string $message
     * @return Response
     */
    public function jsonSuccess(string $message = 'Operation performed successfully'): Response
    {
        return response(['message' => $message], $this->RESPONSE_SUCCESS);
    }

    /**
     * @param string $message
     * @return Response
     */
    public function jsonServerError(string $message = 'Internal server error'): Response
    {
        return response(['message' => $message], $this->RESPONSE_SERVER_ERROR);
    }

    /**
     * @param string $message
     * @return Response
     */
    public function jsonUnAuthorized(string $message = 'Unauthorized'): Response
    {
        return response(['message' => $message], $this->RESPONSE_UNAUTHORIZED);
    }

    /**
     * @param string $message
     * @return Response
     */
    public function jsonBadRequest(string $message = 'Bad Request'): Response
    {
        return response(['message' => $message], $this->RESPONSE_BAD_REQUEST);
    }

    /**
     * @param string $message
     * @return Response
     */
    public function jsonReportSubmitted(string $message = 'ReportSubmitted'): Response
    {
        return response(['message' => $message], $this->UNAVAILABLE_FOR_LEGAL_REASONS);
    }
}
