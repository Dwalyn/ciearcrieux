<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandBusInterface;
use App\Command\CommandHandlerInterface;
use App\Repository\TrainingPeriodRepository;
use Doctrine\ORM\EntityManagerInterface;

class EditTrainingCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly EntityManagerInterface $entityManager,
        private readonly TrainingPeriodRepository $trainingPeriodRepository,
    ) {
    }

    public function __invoke(EditTrainingCommand $command): void
    {
        $data = $command->formData;
        $trainingPeriod = $command->trainingPeriod;

        $diffStart = $trainingPeriod->getStartDate()->diff($data->startDate);
        if ($diffStart->days) {
            $previousTrainingPeriod = $this->trainingPeriodRepository->getPreviousTrainingPeriod($command->trainingPeriod);
            $this->commandBus->dispatch(new UpdateEndPreviousTrainingPeriodCommand($previousTrainingPeriod, $diffStart));
        }

        $diffEnd = $trainingPeriod->getEndDate()->diff($data->endDate);
        if ($diffEnd->days) {
            $nextTrainingPeriod = $this->trainingPeriodRepository->getNextTrainingPeriod($command->trainingPeriod);
            $this->commandBus->dispatch(new UpdateStartNextTrainingPeriodCommand($nextTrainingPeriod, $diffEnd));
        }

        $trainingPeriod->setStartDate($data->startDate);
        $trainingPeriod->setEndDate($data->endDate);
        $trainingPeriod->setTrainingPlace($data->trainingPlace);
        $this->entityManager->flush();
    }
}
