<?php
namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ServiceHttp
{
    public function __construct(protected string $authToken = '')
    {
    }

    public function makeRequest(string $url, string $method = 'get', array $bodyRequest = []): array
    {
        $validMethod = $this->validateRequestMethod($method);
        $response = Http::withToken($this->authToken)->$validMethod($url, $bodyRequest);

        return [
            'statusCode' => $response->status(),
            'data'       => $response->object(),
        ];
    }

    private function validateRequestMethod(string $method) : string
    {
        $validMethods = ['get', 'post', 'put', 'delete'];

        if (! in_array($method, $validMethods)) {
            abort(Response::HTTP_BAD_REQUEST, 'Invalid External Request');
        }

        return $method;
    }
}
