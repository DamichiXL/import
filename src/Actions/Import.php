<?php

namespace DamichiXL\Import\Actions;

use DamichiXL\Import\Imports\ModelImport;

class Import
{
    public function __invoke(array $data): void
    {
        ['file' => $file, 'model' => $model, 'fields' => $fields] = $data;

        $configuration = config('import.models')[$model];

        (new ModelImport($configuration, $fields))->import($file);
    }
}
