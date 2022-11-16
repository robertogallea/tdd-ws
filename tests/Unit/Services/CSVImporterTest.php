<?php

use App\Services\CSVImporter;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can import csv files', function() {
    $content = file_get_contents(__DIR__ . '/../../data/example.csv');

    $service = new CSVImporter();

    $result = $service->import($content);

    $this->assertCount(2, $result);
    $this->assertEquals($result[0]->from, 'EUR');
    $this->assertEquals($result[0]->to, 'USD');
    $this->assertEquals($result[0]->rate, 102);
    $this->assertEquals($result[1]->from, 'EUR');
    $this->assertEquals($result[1]->to, 'GBP');
    $this->assertEquals($result[1]->rate, 70);
});
