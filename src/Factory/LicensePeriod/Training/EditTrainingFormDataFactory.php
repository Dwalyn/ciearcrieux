<?php

namespace App\Factory\LicensePeriod\Training;

use App\Entity\TrainingPeriod;
use App\Form\Datas\LicensePeriod\Training\EditTrainingFormData;

class EditTrainingFormDataFactory
{
    public function __construct()
    {
    }

    public function buildDataTraining(TrainingPeriod $trainingPeriod): EditTrainingFormData
    {
        $editTrainingFormData = new EditTrainingFormData();
        $editTrainingFormData->startDate = $trainingPeriod->getStartDate();
        $editTrainingFormData->endDate = $trainingPeriod->getEndDate();
        $editTrainingFormData->trainingPlace = $trainingPeriod->getTrainingPlace();
        $editTrainingFormData->limitMinDate = $trainingPeriod->getLicensePeriod()->getStartDate()->format('Y-m-d');
        $editTrainingFormData->limitMaxDate = $trainingPeriod->getLicensePeriod()->getEndDate()->format('Y-m-d');

        return $editTrainingFormData;
    }
}
