<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandInterface;
use App\Entity\TrainingDay;

class RemoveTrainingDayCommand implements CommandInterface
{
    public function __construct(
        public readonly TrainingDay $trainingDay,
    ) {
    }
}
