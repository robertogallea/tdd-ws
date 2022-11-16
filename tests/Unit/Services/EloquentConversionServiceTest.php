<?php

use App\Models\Conversion;
use App\Services\EloquentConversionService;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can convert between currencies', function ($from, $to, $amount, $expected) {
    $service = new EloquentConversionService();
    $result = $service->convert($from, $to, $amount);

    $this->assertEquals($expected, $result);
})->with('conversions');

it('raises an exception if the currency does not exist', function () {
    $invalidCurrency = 'XXX';
    $this->expectException(\App\Exceptions\InvalidCurrencyException::class);
    $this->expectExceptionMessage("does not exist");

    $service = new EloquentConversionService();
    $service->convert($invalidCurrency, 'EUR', 1);
});
