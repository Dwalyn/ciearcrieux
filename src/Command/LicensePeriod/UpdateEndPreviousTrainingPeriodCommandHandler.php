<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class UpdateEndPreviousTrainingPeriodCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UpdateEndPreviousTrainingPeriodCommand $command): void
    {
        if ($command->dateInterval->invert) {
            $diff = sprintf('-%s days', $command->dateInterval->days);
        } else {
            $diff = sprintf('+%s days', $command->dateInterval->days);
        }
        $command->trainingPeriod->setEndDate(clone ($command->trainingPeriod->getEndDate())->modify($diff));
        $this->entityManager->flush();
    }
}
