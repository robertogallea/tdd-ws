<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface ImporterInterface
{
    /**
     * @param string $content
     * @return Collection
     */
    public function import(string $content): Collection;
}
