<?php

namespace Tests;

use App\Models\Conversion;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Conversion::factory()->create([
            'from' => 'EUR',
            'to' => 'GBP',
            'rate' => 70,
        ]);
    }
}
