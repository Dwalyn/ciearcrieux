<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandInterface;
use App\Entity\TrainingPeriod;

class UpdateEndPreviousTrainingPeriodCommand implements CommandInterface
{
    public function __construct(
        public TrainingPeriod $trainingPeriod,
        public \DateInterval $dateInterval,
    ) {
    }
}
