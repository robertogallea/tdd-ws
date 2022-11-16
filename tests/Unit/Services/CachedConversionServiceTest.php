<?php

use App\Services\CachedConversionService;

it('can use a cached service', function () {
    $innerService = Mockery::mock(
        \App\Services\ConversionServiceInterface::class,
        function ($mock) {
            $mock->shouldReceive('convert')
                ->with('EUR', 'EUR', 1)
                ->andReturn(1)
                ->once();
        });

    $service = new CachedConversionService($innerService);
    $result1 = $service->convert('EUR', 'EUR', 1);
    $result2 = $service->convert('EUR', 'EUR', 1);

    $this->assertEquals($result1, $result2);
});

it('cache lasts for 1 minute', function () {
    $innerService = Mockery::mock(
        \App\Services\ConversionServiceInterface::class,
        function ($mock) {
            $mock->shouldReceive('convert')
                ->with('EUR', 'EUR', 1)
                ->andReturn(1)
                ->once();
        });

    $service = new CachedConversionService($innerService);
    $result1 = $service->convert('EUR', 'EUR', 1);
    $this->travelTo(\Carbon\Carbon::now()->addSeconds(59));
    $result2 = $service->convert('EUR', 'EUR', 1);

    $this->assertEquals($result1, $result2);
});

test('cache expires after 1 minute', function () {
    $innerService = Mockery::mock(
        \App\Services\ConversionServiceInterface::class,
        function ($mock) {
            $mock->shouldReceive('convert')
                ->with('EUR', 'EUR', 1)
                ->andReturn(1)
                ->twice();
        });

    $service = new CachedConversionService($innerService);
    $result1 = $service->convert('EUR', 'EUR', 1);
    $this->travelTo(\Carbon\Carbon::now()->addMinute()->addSecond());
    $result2 = $service->convert('EUR', 'EUR', 1);

    $this->assertEquals($result1, $result2);
});
