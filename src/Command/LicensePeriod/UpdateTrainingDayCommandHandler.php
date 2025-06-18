<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandHandlerInterface;
use App\Repository\TrainingDayRepository;
use Doctrine\ORM\EntityManagerInterface;

class UpdateTrainingDayCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        public readonly TrainingDayRepository $trainingDayRepository,
        public readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UpdateTrainingDayCommand $command): void
    {
        $trainingDay = $this->trainingDayRepository->findOneBy(['id' => $command->trainingDayFormData->id]);
        if (null !== $command->trainingDayFormData->startTime && null !== $command->trainingDayFormData->endTime) {
            $trainingDay?->setStartTime($command->trainingDayFormData->startTime);
            $trainingDay?->setEndTime($command->trainingDayFormData->endTime);
            $trainingDay?->setDay($command->trainingDayFormData->dayEnum);
            $trainingDay?->setLicensedType($command->trainingDayFormData->licensedTypeEnum);
            $this->entityManager->flush();
        }
    }
}
