<?php

namespace DamichiXL\Import\Listeners;

use DamichiXL\Import\Events\ImportRowStoredEvent;

class ImportRowStoredListener
{
    public function __construct() {}

    public function handle(ImportRowStoredEvent $event): void {}
}
