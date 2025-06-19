<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class RemoveTrainingDayCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(RemoveTrainingDayCommand $command): void
    {
        $this->entityManager->remove($command->trainingDay);
        $this->entityManager->flush();
    }
}
