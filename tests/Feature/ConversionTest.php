<?php

use App\Exceptions\InvalidCurrencyException;
use App\Mail\NotExistingCurrencyConversionRequestedMail;

it('can convert between EUR and EUR with arbitrary amounts', function ($amount) {
    $this->mock(
        \App\Services\ConversionServiceInterface::class,
        function ($mock) use ($amount) {
            $mock->shouldReceive('convert')
                ->with('EUR', 'EUR', $amount)
                ->once()
                ->andReturn($amount);
        }
    );

    $this->postJson('/api/convert', [
        'from' => 'EUR',
        'to' => 'EUR',
        'amount' => $amount
    ])->assertOk()
        ->assertJsonFragment([
            'result' => $amount
        ]);
})->with([1, 2, 3, 5, 10]);

it('can convert between arbitrary currencies', function ($from, $to, $amount, $expected) {
    $this->mock(
        \App\Services\ConversionServiceInterface::class,
        function ($mock) use ($expected, $amount, $to, $from) {
            $mock->shouldReceive('convert')
                ->with($from, $to, $amount)
                ->once()
                ->andReturn($expected);
        }
    );

    $this->postJson('/api/convert', [
        'from' => $from,
        'to' => $to,
        'amount' => $amount
    ])->assertOk()
        ->assertJsonFragment([
            'result' => $expected
        ]);
})->with('conversions');

it('validates input data', function ($override) {
    $this->postJson('/api/convert', array_merge([
        'from' => 'EUR',
        'to' => 'EUR',
        'amount' => 1,
    ], $override))->assertUnprocessable()
        ->assertJsonValidationErrors([array_key_first($override)]);
})->with([
    [['from' => '??']],
    [['from' => '????']],
    [['to' => '??']],
    [['to' => '????']],
    [['amount' => 'a']],
    [['amount' => -1]],
]);

it('returns an error message if conversion for a not existing currency is requested', function () {

    // create a mockup that returns an error
    $this->mock(
        \App\Services\ConversionServiceInterface::class,
        function($mock) {
            $mock->shouldReceive('convert')
                ->with('XXX', 'EUR', 1)
                ->once()
                ->andThrows(new InvalidCurrencyException(message: 'Currency XXX does not exist'));
        }
    );

    // make request
    $this->postJson('/api/convert', [
        'from' => 'XXX',
        'to' => 'EUR',
        'amount' => 1,
    ])->assertNotFound() // do assertions on response
        ->assertJson(['message' => 'Currency XXX does not exist']);
});

test('an email message is sent to the administrator if a conversion for a not existint currency is requested', function () {
    Mail::fake();

    $this->mock(
        \App\Services\ConversionServiceInterface::class,
        function($mock) {
            $mock->shouldReceive('convert')
                ->with('XXX', 'EUR', 1)
                ->once()
                ->andThrows(new InvalidCurrencyException(message: 'Currency XXX does not exist'));
        }
    );

    // make request
    $this->postJson('/api/convert', [
        'from' => 'XXX',
        'to' => 'EUR',
        'amount' => 1,
    ]);

    Mail::assertSent(NotExistingCurrencyConversionRequestedMail::class, function($mail) {
        return $mail->currency == 'XXX' &&
            $mail->to[0]['address'] === 'admin@admin.it';
    });
});


