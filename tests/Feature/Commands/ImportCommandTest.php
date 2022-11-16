<?php

it('can import conversions from the command line', function () {
    $path = __DIR__ . '/../../data/example.csv';
    $content = file_get_contents($path);

    $this->mock(
        \App\Services\ImporterInterface::class,
        function($mock) use ($content) {
            $mock->shouldReceive('import')
                ->with($content)
                ->andReturn((new \Illuminate\Support\Collection())
                ->add(\App\Models\Conversion::make([
                    'from' => 'EUR',
                    'to' => 'USD',
                    'rate' => 102,
                ]))
                ->add(\App\Models\Conversion::make([
                    'from' => 'EUR',
                    'to' => 'GBP',
                    'rate' => 70,
                ])));
        }
    );

    $this->artisan('import:csv ' . $path)

        ->expectsConfirmation("Do you want to import the file {$path}", "Yes")
        ->expectsOutput("2 conversions were imported")
        ->expectsTable(['FROM', 'TO', 'RATE'], [
            ['EUR', 'USD', 102],
            ['EUR', 'GBP', 70],
        ])
        ->assertOk();
});

it('does not import anythong if confirmation is not given', function () {
    $path = __DIR__ . '/../../data/example.csv';
    $content = file_get_contents($path);

    $this->mock(
        \App\Services\ImporterInterface::class,
        function($mock) use ($content) {
            $mock->shouldReceive('import')
                ->with($content)
                ->andReturn(\App\Models\Conversion::factory(2)->make());
        }
    );

    $this->artisan('import:csv ' . $path)
        ->expectsConfirmation("Do you want to import the file {$path}", "No")
        ->assertFailed();
});
