<?php

use App\Http\Middleware\AfterHours;

test('requests before middday are blocked', function () {
    $this->travelTo(\Carbon\Carbon::today()->hour(11));

    $mw = new AfterHours();

    $request = new \Illuminate\Http\Request();

    $mw->handle($request, function() {
        $this->assertFalse(true);
    });

    $this->assertTrue(true);
});

test('requests after midday are allowed', function () {
    $this->travelTo(\Carbon\Carbon::today()->hour(12));

    $mw = new AfterHours();

    $request = new \Illuminate\Http\Request();

    $mw->handle($request, function() {
        $this->assertTrue(true);
    });
});
