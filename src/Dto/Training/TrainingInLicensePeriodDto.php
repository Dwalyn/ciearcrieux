<?php

namespace App\Dto\Training;

use App\Enum\TypePlaceEnum;

class TrainingInLicensePeriodDto
{
    public function __construct(
        public readonly string $id,
        public readonly \DateTime $startDate,
        public readonly \DateTime $endDate,
        public readonly TypePlaceEnum $typePlaceEnum,
    ) {
    }

    public function isActive(): bool
    {
        $nowFormat = (new \DateTime())->format('Ymd');

        if ($this->startDate->format('Ymd') <= $nowFormat
            && $this->endDate->format('Ymd') >= $nowFormat
        ) {
            return true;
        }

        return false;
    }
}
