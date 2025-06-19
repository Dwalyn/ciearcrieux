<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandHandlerInterface;
use App\Entity\TrainingDay;
use Doctrine\ORM\EntityManagerInterface;

class AddTrainingDayCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(AddTrainingDayCommand $command): void
    {
        if (null !== $command->trainingDayFormData->startTime
            && null !== $command->trainingDayFormData->endTime) {
            $trainingDay = new TrainingDay(
                $command->trainingDayFormData->dayEnum,
                $command->trainingDayFormData->startTime,
                $command->trainingDayFormData->endTime,
                $command->trainingDayFormData->licensedTypeEnum,
                $command->trainingPeriod
            );
            $this->entityManager->persist($trainingDay);
            $this->entityManager->flush();
        }
    }
}
