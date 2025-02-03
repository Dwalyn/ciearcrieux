<?php

namespace App\Query\License;

use App\Query\QueryInterface;

class ListRentActiveDtoQuery implements QueryInterface
{
    public function __construct(
        public readonly \DateTime $date,
    ) {
    }
}
