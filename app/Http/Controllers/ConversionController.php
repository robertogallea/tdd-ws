<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidCurrencyException;
use App\Http\Requests\ConversionRequest;
use App\Mail\NotExistingCurrencyConversionRequestedMail;
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
            \Mail::to('admin@admin.it')
                ->send(new NotExistingCurrencyConversionRequestedMail($request->from));

            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }
}
