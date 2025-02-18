<?php

namespace App\Dto\Training;

use App\Enum\LicensedTypeEnum;

class HourPeriodDto
{
    public function __construct(
        public readonly \DateTime $startTime,
        public readonly \DateTime $endTime,
        public readonly LicensedTypeEnum $licensedTypeEnum,
    ) {
    }

    public function getTimePeriod(): string
    {
        return sprintf('%s - %s', $this->startTime->format('H:i'), $this->endTime->format('H:i'));
    }
}
