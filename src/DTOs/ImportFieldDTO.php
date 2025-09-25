<?php

namespace DamichiXL\Import\DTOs;

final readonly class ImportFieldDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $label,
    ) {}

    public static function make(...$args): self
    {
        return new self(...$args);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
        ];
    }
}
