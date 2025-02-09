<?php

namespace App\DataFixtures\trait;

use App\DataFixtures\LicenseDetailFixtures;
use App\DataFixtures\LicensePeriodFixtures;
use App\Entity\LicenseDetail;
use App\Entity\LicensePeriod;

trait FixturesTrait
{
    /**
     * @param array<string, mixed> $data
     */
    public function getReferenceLicensePeriod(array $data, string $key = 'licensePeriod'): LicensePeriod
    {
        return $this->getReference(sprintf('%s_%s', LicensePeriodFixtures::getReferenceName(), $data[$key]), LicensePeriod::class);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function getReferenceLicenseDetail(array $data, string $key = 'licenseDetail'): LicenseDetail
    {
        return $this->getReference(sprintf('%s_%s', LicenseDetailFixtures::getReferenceName(), $data[$key]), LicenseDetail::class);
    }
}
