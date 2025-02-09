<?php

namespace App\Query\License;

use App\Query\QueryInterface;

class ListLicenseActiveDtoQuery implements QueryInterface
{
    public function __construct(
        public readonly \DateTime $date
    ) {
    }
}
