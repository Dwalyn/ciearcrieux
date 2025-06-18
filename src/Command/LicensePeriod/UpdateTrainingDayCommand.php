<?php

namespace App\Command\LicensePeriod;

use App\Command\CommandInterface;
use App\Form\Datas\LicensePeriod\Training\TrainingDayFormData;

class UpdateTrainingDayCommand implements CommandInterface
{
    public function __construct(
        public readonly TrainingDayFormData $trainingDayFormData,
    ) {
    }
}
