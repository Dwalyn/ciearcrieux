<?php

namespace App\Query\FindUs;

use App\Enum\TypePlaceEnum;
use App\Query\QueryInterface;

class TrainingActiveDtoQuery implements QueryInterface
{
    public function __construct(public readonly TypePlaceEnum $typePlaceEnum)
    {
    }
}
