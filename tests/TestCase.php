<?php

namespace DamichiXL\Import\Tests;

use DamichiXL\Import\Providers\ImportServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ImportServiceProvider::class,
        ];
    }
}
