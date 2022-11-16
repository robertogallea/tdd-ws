<?php

namespace App\Services;

use App\Models\Conversion;
use Illuminate\Support\Collection;

class CSVImporter implements ImporterInterface
{

    /**
     * @inheritDoc
     */
    public function import(string $content): Collection
    {
        $result = new Collection();

        foreach (preg_split("/(\r?\n)|(\r\n?)/", $content) as $line) {
            if ($line !== "") {
                $pieces = explode(';', $line);
                $result->add(Conversion::create([
                    'from' => $pieces[0],
                    'to' => $pieces[1],
                    'rate' => $pieces[2] * 100,
                ]));
            }
        }

        return $result;
    }
}
