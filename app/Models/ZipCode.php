<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'zip_code',
        'locality',
        'federal_entity',
        'municipality',
        'created_at',
    ];
}
