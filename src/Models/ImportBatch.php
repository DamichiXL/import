<?php

namespace DamichiXL\Import\Models;

use Illuminate\Database\Eloquent\Model;

class ImportBatch extends Model
{
    protected $fillable = [
        'model',
        'filename',
        'scheme',
    ];

    protected function casts(): array
    {
        return [
            'scheme' => 'array',
        ];
    }
}
