<?php

namespace DamichiXL\Import\DTOs;

use Illuminate\Database\Eloquent\Model;

final readonly class ImportModelDTO extends BaseDTO
{
    /**
     * @param  array<string, ImportFieldDTO>  $fields
     * @param  class-string<Model>  $model
     */
    public function __construct(
        public string $name,
        public string $model,
        public string $key,
        public array $fields,
    ) {}

    public static function make(...$args): self
    {
        return new self(...$args);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'model' => $this->model,
            'key' => $this->key,
            'fields' => $this->fields,
        ];
    }
}
