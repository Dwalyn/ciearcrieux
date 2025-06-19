<?php

namespace App\Factory\LicensePeriod\Training;

use App\Entity\TrainingPeriod;
use App\Form\Datas\LicensePeriod\Training\EditTrainingFormData;
use App\Form\Datas\LicensePeriod\Training\TrainingDayFormData;

class EditTrainingFormDataFactory
{
    public function buildDataTraining(TrainingPeriod $trainingPeriod): EditTrainingFormData
    {
        $editTrainingFormData = new EditTrainingFormData();
        $editTrainingFormData->startDate = $trainingPeriod->getStartDate();
        $editTrainingFormData->endDate = $trainingPeriod->getEndDate();
        $editTrainingFormData->trainingPlace = $trainingPeriod->getTrainingPlace();
        $editTrainingFormData->limitMinDate = $trainingPeriod->getLicensePeriod()->getStartDate()->format('Y-m-d');
        $editTrainingFormData->limitMaxDate = $trainingPeriod->getLicensePeriod()->getEndDate()->format('Y-m-d');

        foreach ($trainingPeriod->getTrainingDays() as $trainingDay) {
            $trainingDayFormData = new TrainingDayFormData();
            $trainingDayFormData->id = $trainingDay->getId();
            $trainingDayFormData->startTime = $trainingDay->getStartTime();
            $trainingDayFormData->endTime = $trainingDay->getEndTime();
            $trainingDayFormData->dayEnum = $trainingDay->getDay();
            $trainingDayFormData->licensedTypeEnum = $trainingDay->getLicensedType();
            $editTrainingFormData->listTrainingDayFormData[] = $trainingDayFormData;
        }

        return $editTrainingFormData;
    }
}
