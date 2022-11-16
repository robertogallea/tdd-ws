<?php

it('can upload a csv file to import', function () {
    $content = file_get_contents(__DIR__ . '/../data/example.csv');

    $this->mock(
        \App\Services\ImporterInterface::class,
        function($mock) use ($content) {
            $mock->shouldReceive('import')
                ->with($content)
                ->andReturn(\App\Models\Conversion::factory(2)->make());
        }
    );

    $this->post('/import', [
        'data' => \Illuminate\Http\UploadedFile::fake()->createWithContent('my_data.csv', $content)
    ])->assertCreated()
        ->assertJsonCount(2, 'data');
});
