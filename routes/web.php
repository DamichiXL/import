<?php

use DamichiXL\Import\Http\Controllers\ImportController;

Route::post('import', ImportController::class)->name('store');
