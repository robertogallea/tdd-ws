<?php

namespace App\Services;

use App\Exceptions\InvalidCurrencyException;
use App\Models\Conversion;

class EloquentConversionService implements ConversionServiceInterface
{
    /**
     * @inheritDoc
     */
    public function convert(string $from, string $to, float $amount): float
    {
        if ($from === $to) {
            return $amount;
        }

        $conversion = Conversion::where([
            'from' => $from,
            'to' => $to,
        ])->first();

        if ($conversion != null) {
            return round($amount * $conversion->rate / 100, 2);
        }

        $conversion = Conversion::where([
            'from' => $to,
            'to' => $from,
        ])->first();

        if ($conversion != null) {
            return round($amount / $conversion->rate * 100, 2);
        }

        throw new InvalidCurrencyException("Currency {$from} does not exist");
    }
}
