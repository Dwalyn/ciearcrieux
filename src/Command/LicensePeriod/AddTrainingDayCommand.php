<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandInterface;
use App\Entity\TrainingPeriod;
use App\Form\Datas\LicensePeriod\Training\TrainingDayFormData;

class AddTrainingDayCommand implements CommandInterface
{
    public function __construct(
        public readonly TrainingDayFormData $trainingDayFormData,
        public readonly TrainingPeriod $trainingPeriod,
    ) {
    }
}
