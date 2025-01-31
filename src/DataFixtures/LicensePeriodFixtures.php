<?php

namespace App\DataFixtures;

use App\Entity\LicensePeriod;

class LicensePeriodFixtures extends AbstractFixture
{
    protected function buildEntity(array $data): LicensePeriod
    {
        return new LicensePeriod(
            new \DateTime($data['startDate']),
            new \DateTime($data['endDate'])
        );
    }

    public static function getReferenceName(): string
    {
        return 'licensePeriod';
    }
}
