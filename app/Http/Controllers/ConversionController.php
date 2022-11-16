<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConversionRequest;
use App\Services\ConversionServiceInterface;
use App\Services\EloquentConversionService;
use Illuminate\Http\Request;


class ConversionController extends Controller
{
    public function __invoke(ConversionRequest $request, ConversionServiceInterface $service)
    {
        $result = $service->convert($request->from, $request->to, $request->amount);

        return response()->json([
            'result' => $result,
        ]);
    }
}
