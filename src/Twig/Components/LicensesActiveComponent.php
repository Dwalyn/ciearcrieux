<?php

namespace App\Twig\Components;

use App\Dto\License\LicenceActiveDto;
use App\Query\JoinUs\ListLicenseActiveDtoQuery;
use App\Query\QueryBusInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class LicensesActiveComponent
{
    /**
     * @var ArrayCollection<int, LicenceActiveDto>
     */
    private ArrayCollection $listLicenseActiveDto;

    public function __construct(
        private readonly QueryBusInterface $query,
    ) {
        $this->listLicenseActiveDto = new ArrayCollection();
        $this->listLicenseActiveDto = $this->query->handle(new ListLicenseActiveDtoQuery(new \DateTime()));
    }

    /**
     * @return ArrayCollection<int, LicenceActiveDto>
     */
    public function getLicencesInPeriod(): ArrayCollection
    {
        return $this->listLicenseActiveDto;
    }
}
