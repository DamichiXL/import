<?php

namespace DamichiXL\Import\Http\Controllers;

use DamichiXL\Import\Actions\Import;
use DamichiXL\Import\Http\Requests\ImportRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function __invoke(ImportRequest $request, Import $import)
    {
        DB::transaction(fn () => $import($request->validated()));

        return response()->json([
            'message' => __('import::messages.success'),
        ]);
    }
}
