<?php

namespace App\Services;

interface ConversionServiceInterface
{
    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return mixed
     */
    public function convert(string $from, string $to, float $amount): float;
}
