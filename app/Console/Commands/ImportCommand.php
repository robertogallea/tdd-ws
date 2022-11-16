<?php

namespace App\Console\Commands;

use App\Services\ImporterInterface;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import conversions from a csv file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ImporterInterface $importer)
    {
        $path = $this->argument('path');
        $confirm = $this->confirm("Do you want to import the file {$path}");
        if (!$confirm) {
            return Command::FAILURE;
        }

        $results = $importer->import(file_get_contents($path));
        $this->info("{$results->count()} conversions were imported");
        $this->table(['FROM', 'TO', 'RATE'],
            $results->map(fn($item) => collect($item->toArray())->only('from', 'to', 'rate')->all())
        );
        return Command::SUCCESS;
    }
}
