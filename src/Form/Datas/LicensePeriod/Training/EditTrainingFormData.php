<?php

namespace App\Form\Datas\LicensePeriod\Training;

use App\Entity\TrainingPlace;
use Symfony\Component\Validator\Constraints as Assert;

class EditTrainingFormData
{
    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(propertyPath: 'limitMinDate')]
    #[Assert\LessThanOrEqual(propertyPath: 'limitMaxDate')]
    #[Assert\LessThan(propertyPath: 'endDate')]
    public ?\DateTime $startDate;

    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(propertyPath: 'limitMinDate')]
    #[Assert\LessThanOrEqual(propertyPath: 'limitMaxDate')]
    #[Assert\GreaterThan(propertyPath: 'startDate')]
    public ?\DateTime $endDate;

    public TrainingPlace $trainingPlace;
    public string $limitMinDate;
    public string $limitMaxDate;
}
