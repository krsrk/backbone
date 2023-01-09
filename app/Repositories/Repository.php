<?php

namespace App\Repositories;

interface Repository
{
    const NUMBER_PAGINATE_RECORDS = 10;

    public function all($numberPaginatedRecords = self::NUMBER_PAGINATE_RECORDS);

    public function findById(string $id);

    public function findBy(string $field, mixed $value);

    public function store($data);

    public function update(string $id, $data);

    public function delete(string $id);
}
