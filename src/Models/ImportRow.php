<?php

namespace DamichiXL\Import\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportRow extends Model
{
    protected $fillable = [
        'import_batch_id',
        'data',
        'message',
        'success',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'success' => 'boolean',
            'processed_at' => 'datetime',
        ];
    }

    public function importBatch(): BelongsTo
    {
        return $this->belongsTo(ImportBatch::class);
    }
}
