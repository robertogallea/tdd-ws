<?php

namespace App\Http\Controllers;

use App\Services\EloquentConversionService;
use Illuminate\Http\Request;


class ConversionController extends Controller
{
    public function __invoke(Request $request, EloquentConversionService $service)
    {
        $result = $service->convert($request->from, $request->to, $request->amount);

        return response()->json([
            'result' => $result,
        ]);
    }
}
