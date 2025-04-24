<?php

namespace App\Twig\Components;

use App\Dto\License\RentActiveDto;
use App\Query\JoinUs\ListRentActiveDtoQuery;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class RentsActiveComponent extends LicensesActiveComponent
{
    /**
     * @return ArrayCollection<int, RentActiveDto>
     */
    public function getRentsInPeriod(): ?ArrayCollection
    {
        return $this->query->handle(new ListRentActiveDtoQuery($this->startDate, $this->endDate));
    }
}
