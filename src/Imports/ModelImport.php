<?php

namespace DamichiXL\Import\Imports;

use DamichiXL\Import\DTOs\ImportModelDTO;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class ModelImport implements SkipsEmptyRows, ToModel, WithBatchInserts, WithChunkReading, WithStartRow, WithUpserts, WithValidation
{
    use Importable;

    public function __construct(protected ImportModelDTO $configuration, protected array $fields) {}

    public function model(array $row): ?Model
    {
        $model = $this->configuration->model;

        return new $model(
            $this->getProperties($row)
        );
    }

    private function getProperties($row): array
    {
        return collect($this->fields)->mapWithKeys(fn ($field) => [
            $field['value'] => $row[$field['order']],
        ])->toArray();
    }

    public function uniqueBy(): array|string
    {
        return $this->configuration->key;
    }

    public function batchSize(): int
    {
        return 10;
    }

    public function chunkSize(): int
    {
        return 10;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [];
    }
}
