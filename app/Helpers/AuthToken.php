<?php

namespace App\Helpers;

use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthToken
{
    protected mixed $validator;
    protected string $authToken;

    public function __construct($validator=null)
    {
        if (! is_null($validator)) {
            $this->validator = $validator;
            $this->setAuthToken();
        }
    }

    protected function setAuthToken()
    {
        $token = JWTAuth::attempt($this->validator->validated());

        if (! $token) {
            $token = '';
        }

        $this->authToken = $token;
    }

    public function getAuthToken($refreshToken='') : array
    {
        $this->authToken = ($refreshToken == '') ? $this->authToken : $refreshToken;

        return $this->getAuthTokenData();
    }

    protected function getAuthTokenData() : array
    {
        $tokenArrResponse= [
            'access_token' => $this->authToken,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
        ];

        if ($tokenArrResponse['access_token'] == '') {
            $tokenArrResponse['error'] = [
                'message' => 'Login Failed: Bad Credentials',
                'code'    => 401,
            ];
        }

        return $tokenArrResponse;
    }

    public function getAuthTokenPayloadData($getUserData = false)
    {
        $jwtToken = JWTAuth::getToken();
        $tokenPayloadData = JWTAuth::getPayload($jwtToken)->toArray();

        return (! $getUserData) ? $tokenPayloadData : $tokenPayloadData['data'];
    }
}
