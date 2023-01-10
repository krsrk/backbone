<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    use HasFactory, HasUuids;

    public $table = 'zip_codes';
    protected $fillable = [
        'zip_code',
        'locality',
        'federal_entity',
        'municipality',
        'created_at',
    ];

    //protected $with = ['settlements'];

    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'zip_code_id');
    }
}
