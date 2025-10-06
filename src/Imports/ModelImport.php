<?php

namespace DamichiXL\Import\Imports;

use DamichiXL\Import\DTOs\ImportModelDTO;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;

class ModelImport implements OnEachRow, SkipsEmptyRows, WithBatchInserts, WithChunkReading, WithStartRow, WithValidation
{
    use Importable;

    public function __construct(protected ImportModelDTO $configuration, protected array $fields) {}

    public function onRow(Row $row): void
    {
        $row = $row->toArray();

        $model = $this->configuration->model;

        $properties = $this->getProperties($row);

        if (Arr::has($properties, $this->configuration->key)) {
            $model::updateOrCreate(
                [
                    $this->configuration->key => $properties[$this->configuration->key],
                ],
                Arr::except($properties, $this->configuration->key),
            );
        } else {
            $model::create($properties);
        }
    }

    private function getProperties($row): array
    {
        return collect($this->fields)->mapWithKeys(fn ($field) => [
            $field['value'] => $row[$field['order']],
        ])->toArray();
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
