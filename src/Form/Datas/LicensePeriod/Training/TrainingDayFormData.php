<?php

namespace App\Form\Datas\LicensePeriod\Training;

use App\Enum\DayEnum;
use App\Enum\LicensedTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

class TrainingDayFormData
{
    public ?string $id;

    #[Assert\NotNull]
    #[Assert\LessThan(propertyPath: 'endTime', message: 'constraint.startTime')]
    public ?\DateTime $startTime;

    #[Assert\NotNull]
    #[Assert\GreaterThan(propertyPath: 'startTime', message: 'constraint.endTime')]
    public ?\DateTime $endTime;

    #[Assert\NotNull]
    public ?DayEnum $dayEnum;

    #[Assert\NotNull]
    public ?LicensedTypeEnum $licensedTypeEnum;
}
