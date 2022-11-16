<?php

use App\Models\Conversion;
use App\Services\EloquentConversionService;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can convert between currencies', function ($from, $to, $amount, $expected) {
    $service = new EloquentConversionService();
    $result = $service->convert($from, $to, $amount);

    $this->assertEquals($expected, $result);
})->with('conversions');
