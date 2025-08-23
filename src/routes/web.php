<?php

use DamichiXL\Import\Controllers\ImportController;

Route::post('import', ImportController::class)->name('store');
