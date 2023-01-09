<?php

namespace App\Http\Middleware;

use App\Helpers\ModuleAclData;
use App\Repositories\ModuleRepository;
use Closure;
use Illuminate\Http\Request;
use App\Helpers\AuthToken;
use Illuminate\Http\Response;

class AclVerify
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
        $moduleAcl = ModuleAclData::getData($request->route()->getName());

        if (! $moduleAcl['hasModule']) {
            return response()->json(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        if (! $moduleAcl['hasModuleAcl'] || ! $moduleAcl['data']['can_access']) {
            return response()->json(['message' => 'Forbidden resource'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
