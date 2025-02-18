<?php

namespace App\Dto\Training;

use App\Enum\DayEnum;
use Doctrine\Common\Collections\ArrayCollection;

class DayDto
{
    /**
     * @var ArrayCollection<int, HourPeriodDto>
     */
    private ArrayCollection $listHourPeriodDto;

    public function __construct(
        public readonly DayEnum $day,
    ) {
        $this->listHourPeriodDto = new ArrayCollection();
    }

    /**
     * @return ArrayCollection<int, HourPeriodDto>
     */
    public function getListHourPeriodDto(): ArrayCollection
    {
        return $this->listHourPeriodDto;
    }
}
