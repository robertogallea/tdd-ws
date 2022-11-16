<?php

use App\Models\Conversion;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can convert between EUR and EUR with arbitrary amounts', function ($amount) {
    $this->post('/api/convert', [
        'from' => 'EUR',
        'to' => 'EUR',
        'amount' => $amount
    ])->assertOk()
        ->assertJsonFragment([
            'result' => $amount
        ]);
})->with([1, 2, 3, 5, 10]);

it('can convert between arbitrary currencies', function($from, $to, $amount, $expected) {
    $this->post('/api/convert', [
        'from' => $from,
        'to' => $to,
        'amount' => $amount
    ])->assertOk()
        ->assertJsonFragment([
            'result' => $expected
        ]);
})->with('conversions');


