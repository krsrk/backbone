<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ZipCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'zip_code' => $this->zip_code,
            'locality' => $this->locality,
            'federal_entity' => json_decode($this->federal_entity),
            'settlements' => SettlementResource::collection($this->settlements),
            'municipality' => json_decode($this->municipality)
        ];
    }

    public static function collection($resource)
    {
        return parent::collection($resource);
    }
}
