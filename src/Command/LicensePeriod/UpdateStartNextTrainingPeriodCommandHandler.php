<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class UpdateStartNextTrainingPeriodCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(UpdateStartNextTrainingPeriodCommand $command): void
    {
        if ($command->dateInterval->invert) {
            $diff = sprintf('-%s days', $command->dateInterval->days);
        } else {
            $diff = sprintf('+%s days', $command->dateInterval->days);
        }
        $command->trainingPeriod->setStartDate(clone ($command->trainingPeriod->getStartDate())->modify($diff));
        $this->entityManager->flush();
    }
}
