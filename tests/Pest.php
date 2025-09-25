<?php

use DamichiXL\Import\Tests\TestCase;

pest()->extend(TestCase::class)
    ->in(__DIR__);

function getDataFromCSV($file): array
{
    $handle = fopen($file, 'r');
    $header = true;

    $data = [];

    while (($row = fgetcsv($handle, 1000)) !== false) {
        if ($header) {
            $header = false;
        } else {
            $data[] = $row;
        }
    }

    fclose($handle);

    return $data;
}
