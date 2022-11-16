<?php

namespace App\Services;

use App\Models\Conversion;

class EloquentConversionService
{
    public function convert(string $from, string $to, float $amount)
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

        return round($amount / $conversion->rate * 100, 2);
    }
}
