<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZipCodeRequest;
use App\Http\Resources\ZipCodeResource;
use App\Repositories\ZipCodeRepository;

class ZipCodeController extends Controller
{
    public function __construct(protected ZipCodeRepository $repository){}

    public function index(ZipCodeRequest $request, string $zipCode)
    {
        return response()->json(
            new ZipCodeResource(
                $this->repository->toCache($this->repository->findBy('zip_code', $zipCode))
            )
        );
    }
}
