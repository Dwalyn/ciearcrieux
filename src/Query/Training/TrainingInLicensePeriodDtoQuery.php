<?php

namespace App\Query\Training;

use App\Entity\LicensePeriod;
use App\Query\QueryInterface;

class TrainingInLicensePeriodDtoQuery implements QueryInterface
{
    public function __construct(
        public readonly LicensePeriod $licensePeriod
    ) {
    }
}
