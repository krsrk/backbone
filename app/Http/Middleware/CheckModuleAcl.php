<?php

namespace App\Http\Middleware;

use App\Services\Auth\AuthService;
use App\Services\ServiceHttp;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class CheckModuleAcl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $jwtToken = JWTAuth::getToken();
        $requestErrors = [
            Response::HTTP_NOT_FOUND => 'Resource not found',
            Response::HTTP_FORBIDDEN => 'Forbidden resource',
            Response::HTTP_INTERNAL_SERVER_ERROR => 'Internal Error'
        ];

        if(! is_null($jwtToken)) {
            $tokenPayloadData = JWTAuth::getPayload($jwtToken)->toArray();
            $response = (new ServiceHttp(JWTAuth::getToken()))->makeRequest(
                env('MRB_AUTH_SERVICE_CHECK_MODULE'),
                'post',
                [
                    'route_name'   => $request->route()->getName(),
                    'user_role_id' => $tokenPayloadData['data']['role']['id']
                ]
            );

            if (isset($requestErrors[$response['statusCode']])) {
                return response()->json(['message' => $requestErrors[$response['statusCode']]], $response['statusCode']);
            }
        }

        return $next($request);
    }
}
