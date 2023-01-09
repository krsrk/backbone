<?php

namespace App\Repositories;

use App\Models\ZipCode;

class ZipCodeRepository implements Repository
{
    protected $model;

    public function __construct()
    {
        $this->model = ZipCode::class;
    }

    public function all($numberPaginatedRecords = self::NUMBER_PAGINATE_RECORDS)
    {
        // TODO: Implement all() method.
    }

    public function findById(string $id)
    {
        // TODO: Implement findById() method.
    }

    public function findBy(string $field, mixed $value)
    {
        // TODO: Implement findBy() method.
    }

    public function store($data) : ZipCode
    {
        $fedEnt = [
            'key' => (int)$data['c_estado'],
            'name' => $data['d_estado'],
            'code' => $data['c_CP'],
        ];

        $municipality = [
            'key' => (int)$data['c_mnpio'],
            'name' => $data['D_mnpio'],
        ];

        return $this->model::updateOrCreate(
            ['zip_code' => $data['d_codigo']],
            [
                'locality' => (isset($dat['d_ciudad'])) ? $dat['d_ciudad'] : '',
                'federal_entity' => json_encode($fedEnt),
                'municipality' => json_encode($municipality),
                'created_at' => date('Y-m-d H:i:s'),
            ]
        );
    }

    public function update(string $id, $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(string $id)
    {
        // TODO: Implement delete() method.
    }
}