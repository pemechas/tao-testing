<?php
namespace App\DBConnection;

/**
 * Default HTTP response for the API
 *
 * @author Jose Maria Toribio
 */
class ResponseHttpApi
{
    /**
     * Returns defaul HTTP response
     *
     * @param string $status
     * @param int $codeResponse
     * @param array $data
     * @return array
     */
    public function response(
        string $status,
        int $codeResponse,
        array $data = []
    ) : array
    {
        return [
            'status' => $status,
            'code' => $codeResponse,
            'data' => $data
        ];
    }
}
