<?php

namespace App\Twig\Components\Administration\LicensePeriod;

use App\Enum\TimeStatusEnum;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class PeriodComponent
{
    public int $id;
    public string $startYear;
    public string $endYear;
    public TimeStatusEnum $timeStatusEnum;
}
