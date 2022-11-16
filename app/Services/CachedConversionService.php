<?php

namespace App\Services;

class CachedConversionService implements ConversionServiceInterface
{
    public function __construct(protected ConversionServiceInterface $innerService)
    {

    }

    /**
     * @inheritDoc
     */
    public function convert(string $from, string $to, float $amount): float
    {
        return \Cache::remember(
            "{$from}_{$to}_{$amount}",
            60,
            fn() => $this->innerService->convert($from, $to, $amount)
        );
    }
}
