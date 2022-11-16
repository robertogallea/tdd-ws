<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversionController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'result' => $request->amount,
        ]);
    }
}
