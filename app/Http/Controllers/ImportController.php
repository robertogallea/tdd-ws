<?php

namespace App\Http\Controllers;

use App\Services\ImporterInterface;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function __invoke(ImporterInterface $importer, Request $request)
    {
        $result = $importer->import(file_get_contents($request->file('data')));

        return response()->json(['data' => $result->toArray()], 201);
    }
}
