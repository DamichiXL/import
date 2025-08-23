<?php

use DamichiXL\Import\controllers\ImportController;

Route::post('import', ImportController::class)->name('store');
