<?php

use App\Services\APIConversionService;

it('can convert between currencies', function ($from, $to, $amount, $expected) {
    \Illuminate\Support\Facades\Http::fake([
        'https://api.apilayer.com/*' => Http::response([
            'result' => $expected,
            'success' => true,
        ])
    ]);

    $apiKey = 'an-api-key';

    $service = new APIConversionService($apiKey);
    $result = $service->convert($from, $to, $amount);

    $this->assertEquals($expected, $result);
})->with('conversions');

it('raises an exception if the currency does not exist', function () {
    $this->expectException(\App\Exceptions\InvalidCurrencyException::class);
    $this->expectExceptionMessage("does not exist");

    \Illuminate\Support\Facades\Http::fake([
        'https://api.apilayer.com/*' => Http::response([
            'success' => false,
        ])
    ]);

    $apiKey = 'an-api-key';

    $service = new APIConversionService($apiKey);
    $result = $service->convert('XXX', 'EUR', 1);
});
