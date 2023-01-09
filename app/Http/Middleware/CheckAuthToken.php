<?php

namespace App\Http\Middleware;

use App\Services\ServiceHttp;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery\Exception;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class CheckAuthToken
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
        try {
            $authServiceRequest = (new ServiceHttp(JWTAuth::getToken()))->makeRequest(
                env('MRB_AUTH_SERVICE_CHECK_URL'),
                'post'
            );

            if ($authServiceRequest['statusCode'] == Response::HTTP_UNAUTHORIZED) {
                return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $next($request);
    }
}
