<?php

namespace App\Query\FindUs;

use App\Entity\LicensePeriod;
use App\Enum\TypePlaceEnum;
use App\Query\QueryInterface;

class TrainingActiveDtoQuery implements QueryInterface
{
    public function __construct(
        public readonly ?TypePlaceEnum $typePlaceEnum = null,
        public readonly ?string $id = null,
        public readonly ?LicensePeriod $licensePeriod = null,
    ) {
    }
}
