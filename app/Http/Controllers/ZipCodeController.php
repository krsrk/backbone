<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZipCodeRequest;
use App\Http\Resources\ZipCodeResource;
use App\Repositories\ZipCodeRepository;
use Illuminate\Http\Response;

class ZipCodeController extends Controller
{
    public function __construct(protected ZipCodeRepository $repository){}

    public function index(ZipCodeRequest $request, Response $response, string $zipCode)
    {
        $zipCodes = $this->repository->findBy('zip_code', $zipCode);
        $responseData = (is_null($zipCodes)) ? [] : new ZipCodeResource($zipCodes);
        $responseCode = (is_null($zipCodes)) ?  $response::HTTP_NOT_FOUND : $response::HTTP_OK;

        return response()->json($responseData, $responseCode);
    }
}
