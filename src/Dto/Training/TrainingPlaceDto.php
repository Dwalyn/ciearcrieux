<?php

namespace App\Dto\Training;

use App\Enum\TypePlaceEnum;
use Doctrine\Common\Collections\ArrayCollection;

class TrainingPlaceDto
{
    private \DateTime $startDate;
    private \DateTime $endDate;
    /**
     * @var ArrayCollection<int, DayDto>
     */
    private ArrayCollection $listDayDto;

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly TypePlaceEnum $typePlaceEnum,
        public readonly AdressDto $adressDto,
        \DateTime $startDate,
        \DateTime $endDate,
    ) {
        $this->listDayDto = new ArrayCollection();
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function addDayDto(DayDto $dayDto): void
    {
        $this->listDayDto->add($dayDto);
    }

    /**
     * @return ArrayCollection<int, DayDto>
     */
    public function getListDayDto(): ArrayCollection
    {
        return $this->listDayDto;
    }

    public function getPeriodDate(): string
    {
        return sprintf('%s - %s', $this->startDate->format('d/m/Y'), $this->endDate->format('d/m/Y'));
    }
}
