<?php


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
