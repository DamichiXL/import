<?php

namespace DamichiXL\Import\DTOs;

final readonly class ImportModelDTO extends BaseDTO
{
    /**
     * @param  array<string, ImportFieldDTO>  $fields
     */
    public function __construct(
        protected string $name,
        protected string $model,
        protected string $key,
        protected array $fields,
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
