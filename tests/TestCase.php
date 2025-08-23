<?php

namespace DamichiXL\Import\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application for testing by bootstrapping the host Laravel app.
     */
    public function createApplication(): Application
    {
        // Resolve path to the host application's bootstrap/app.php
        $appPath = dirname(__DIR__, 4) . '/bootstrap/app.php';

        /** @var Application $app */
        $app = require $appPath;

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
