<?php

namespace DamichiXL\Import\Http\Controllers;

use DamichiXL\Import\Http\Requests\ImportRequest;
use Illuminate\Routing\Controller;

class ImportController extends Controller
{
    public function __invoke(ImportRequest $request) {}
}
