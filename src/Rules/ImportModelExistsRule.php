<?php

namespace DamichiXL\Import\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ImportModelExistsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $allowed = array_keys(config('import.models'));

        if (! in_array($value, $allowed)) {
            $fail('import::validation.model_not_found')->translate([
                'attribute' => $attribute,
                'allowed' => implode(', ', $allowed),
            ]);
        }
    }
}
