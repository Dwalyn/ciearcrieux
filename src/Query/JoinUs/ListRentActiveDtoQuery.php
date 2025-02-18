<?php

namespace App\Query\JoinUs;

use App\Query\QueryInterface;

class ListRentActiveDtoQuery implements QueryInterface
{
    public function __construct(
        public readonly \DateTime $date,
    ) {
    }
}
