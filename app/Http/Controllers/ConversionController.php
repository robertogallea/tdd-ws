<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidCurrencyException;
use App\Http\Requests\ConversionRequest;
use App\Services\ConversionServiceInterface;
use App\Services\EloquentConversionService;
use Illuminate\Http\Request;


class ConversionController extends Controller
{
    public function __invoke(ConversionRequest $request, ConversionServiceInterface $service)
    {
        try {
            $result = $service->convert($request->from, $request->to, $request->amount);

            return response()->json([
                'result' => $result,
            ]);
        } catch (InvalidCurrencyException $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }
}
