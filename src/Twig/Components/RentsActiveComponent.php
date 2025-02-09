<?php

namespace App\Twig\Components;

use App\Dto\License\RentActiveDto;
use App\Query\License\ListRentActiveDtoQuery;
use App\Query\QueryBusInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class RentsActiveComponent
{
    /**
     * @var ArrayCollection<int, RentActiveDto>
     */
    private ArrayCollection $listRentActiveDto;

    public function __construct(
        private readonly QueryBusInterface $query,
    ) {
        $this->listRentActiveDto = $this->query->handle(new ListRentActiveDtoQuery(new \DateTime()));
    }

    /**
     * @return ArrayCollection<int, RentActiveDto>
     */
    public function getRentsInPeriod(): ArrayCollection
    {
        return $this->listRentActiveDto;
    }
}
