<?php

namespace App\Services;

use App\Exceptions\InvalidCurrencyException;
use Illuminate\Support\Facades\Http;

class APIConversionService implements ConversionServiceInterface
{

    public function __construct(protected string $apiKey)
    {

    }

    /**
     * @inheritDoc
     */
    public function convert(string $from, string $to, float $amount): float
    {
        $response = Http::withHeaders([
            'Content-Type' => 'text/plain',
            'apikey' => $this->apiKey,
        ])->get("https://api.apilayer.com/exchangerates_data/convert?to={$to}&from={$from}&amount={$amount}");

        throw_if(!$response->json('success'), new InvalidCurrencyException(message: "The currency {$from} does not exist"));

        return $response->json('result');
    }
}
