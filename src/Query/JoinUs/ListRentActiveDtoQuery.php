<?php

namespace App\Query\JoinUs;

use App\Entity\LicensePeriod;
use App\Query\QueryInterface;

class ListRentActiveDtoQuery implements QueryInterface
{
    public function __construct(public readonly ?LicensePeriod $licensePeriod = null)
    {
    }
}
