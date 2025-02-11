<?php

namespace App\DataFixtures\trait;

use App\DataFixtures\LicenseDetailFixtures;
use App\DataFixtures\LicensePeriodFixtures;
use App\DataFixtures\TrainingPeriodFixtures;
use App\Entity\LicenseDetail;
use App\Entity\LicensePeriod;
use App\Entity\TrainingPeriod;

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

    /**
     * @param array<string, mixed> $data
     */
    public function getReferenceTrainingPeriod(array $data, string $key = 'trainingPeriod'): TrainingPeriod
    {
        return $this->getReference(sprintf('%s_%s', TrainingPeriodFixtures::getReferenceName(), $data[$key]), TrainingPeriod::class);
    }
}
