<?php

namespace App\DataFixtures\trait;

use App\DataFixtures\LicenseDetailFixtures;
use App\DataFixtures\LicensePeriodFixtures;
use App\DataFixtures\TrainingPeriodFixtures;
use App\DataFixtures\TrainingPlaceFixtures;
use App\Entity\LicenseDetail;
use App\Entity\LicensePeriod;
use App\Entity\TrainingPeriod;
use App\Entity\TrainingPlace;

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

    /**
     * @param array<string, mixed> $data
     */
    public function getReferenceTrainingPlace(array $data, string $key = 'trainingPlace'): TrainingPlace
    {
        return $this->getReference(sprintf('%s_%s', TrainingPlaceFixtures::getReferenceName(), $data[$key]), TrainingPlace::class);
    }
}
