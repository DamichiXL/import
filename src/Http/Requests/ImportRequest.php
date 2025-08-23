<?php

namespace DamichiXL\Import\Http\Requests;

use DamichiXL\Import\Rules\ImportFieldExistsRule;
use DamichiXL\Import\Rules\ImportModelExistsRule;
use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls',
            ],
            'model' => [
                'required',
                'string',
                new ImportModelExistsRule,
            ],
            'fields' => [
                'required',
                'array',
            ],
            'fields.*.order' => [
                'required',
                'integer',
            ],
            'fields.*.value' => [
                'required',
                'string',
                new ImportFieldExistsRule($this->input('model')),
            ],
        ];
    }
}
