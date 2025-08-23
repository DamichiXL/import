<?php

namespace DamichiXL\Import\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ImportFieldExistsRule implements ValidationRule
{
    public function __construct(protected ?string $model) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($this->model)) {
            $fail('import::validation.model_cannot_be_null')->translate([
                'attribute' => $attribute,
            ]);
        }

        $allowed = array_map(
            fn ($field) => $field['name'],
            config("import.models.{$this->model}.fields")
        );

        if (! in_array($value, $allowed)) {
            $fail('import::validation.field_not_found')->translate([
                'attribute' => $attribute,
                'allowed' => implode(', ', $allowed),
            ]);
        }
    }
}
