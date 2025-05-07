<?php

namespace App\Factory\LicensePeriod;

use App\Entity\License;
use App\Entity\LicensePeriod;
use App\Entity\Rent;
use App\Enum\TimeStatusEnum;
use App\Repository\LicenseDetailRepository;
use App\Repository\LicenseRepository;
use App\Repository\RentRepository;
use Doctrine\ORM\EntityManagerInterface;

class LicensePeriodFactory
{
    public function __construct(
        private LicenseRepository $licenseRepository,
        private LicenseDetailRepository $licenseDetailRepository,
        private RentRepository $rentRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function buildNewLicensePeriod(LicensePeriod $lastLicensePeriod): LicensePeriod
    {
        $startDate = (clone $lastLicensePeriod->getStartDate())->modify('+1 year');
        $endDate = (clone $lastLicensePeriod->getEndDate())->modify('+1 year');

        if ($startDate->format('Ymd') > (new \DateTime())->format('Ymd')) {
            $status = TimeStatusEnum::NOT_BEGIN;
        } else {
            $status = TimeStatusEnum::IN_PROGRESS;
            $lastLicensePeriod->setStatus(TimeStatusEnum::FINISHED);
        }
        $licensePeriod = new LicensePeriod($startDate, $endDate, $status);
        $this->entityManager->persist($licensePeriod);

        return $licensePeriod;
    }

    public function buildLicenseInLicensePeriod(LicensePeriod $lastLicensePeriod, LicensePeriod $newLicensePeriod): void
    {
        $listLicense = $this->licenseRepository->findBy(['licensePeriod' => $lastLicensePeriod]);
        foreach ($listLicense as $license) {
            $newLicense = new License($license->getType(), $license->getPrice(), $newLicensePeriod);

            $licenseDetailsIds = $this->licenseRepository->getIdLicenseDetails($license);
            $listLicenseDetail = $this->licenseDetailRepository->findByIds($licenseDetailsIds);
            foreach ($listLicenseDetail as $licenseDetail) {
                $newLicense->addLicenceDetail($licenseDetail);
            }
            $this->entityManager->persist($newLicense);
        }
    }

    public function buildRentInLicensePeriod(LicensePeriod $lastLicensePeriod, LicensePeriod $newLicensePeriod): void
    {
        $listRent = $this->rentRepository->findBy(['licensePeriod' => $lastLicensePeriod]);
        foreach ($listRent as $rent) {
            $newRent = new Rent($rent->getType(), $rent->getPrice(), $newLicensePeriod);
            $this->entityManager->persist($newRent);
        }
    }
}
