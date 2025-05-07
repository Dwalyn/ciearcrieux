<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandBusInterface;
use App\Command\CommandHandlerInterface;
use App\Entity\LicensePeriod;
use App\Repository\LicensePeriodRepository;

class CheckLicensePeriodCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private LicensePeriodRepository $licensePeriodRepository,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(CheckLicensePeriodCommand $query): void
    {
        /**
         * @var LicensePeriod $lastLicensePeriod
         */
        $lastLicensePeriod = $this->licensePeriodRepository->getLastPeriod();
        if ($lastLicensePeriod->getEndDate()->format('Ymd') < (new \DateTime())->format('Ymd')) {
            $this->commandBus->dispatch(new NewLicensePeriodCommand());
        }
    }
}
