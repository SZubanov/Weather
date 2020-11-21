<?php

declare(strict_types=1);

namespace App\Services;


use App\Services\Traits\DatatableTrait;

class Service
{
    use DatatableTrait;

    public function getDataForIndex(): array
    {
        return [];
    }

    public function getDataForCreate(): array
    {
        return [];
    }

}
