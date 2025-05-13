<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandHandlerInterface;
use App\Entity\LicensePeriod;
use App\Factory\LicensePeriod\LicensePeriodFactory;
use App\Repository\LicensePeriodRepository;
use Doctrine\ORM\EntityManagerInterface;

class NewLicensePeriodCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LicensePeriodRepository $licensePeriodRepository,
        private LicensePeriodFactory $licensePeriodFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(NewLicensePeriodCommand $command): void
    {
        /**
         * @var LicensePeriod $lastLicensePeriod
         */
        $lastLicensePeriod = $this->licensePeriodRepository->getLastPeriod();
        $newLicensePeriod = $this->licensePeriodFactory->buildNewLicensePeriod($lastLicensePeriod);
        $this->licensePeriodFactory->buildLicenseInLicensePeriod($lastLicensePeriod, $newLicensePeriod);
        $this->licensePeriodFactory->buildRentInLicensePeriod($lastLicensePeriod, $newLicensePeriod);
        $this->licensePeriodFactory->buildTrainingPeriodInLicensePeriod($lastLicensePeriod, $newLicensePeriod);
        $this->entityManager->flush();
    }
}
