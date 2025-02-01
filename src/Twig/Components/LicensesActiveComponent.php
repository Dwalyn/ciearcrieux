<?php

namespace App\Twig\Components;

use App\Query\License\ListLicenseActiveDtoQuery;
use App\Query\QueryBusInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class LicensesActiveComponent
{
    private string $periodDate;
    private ArrayCollection $listLicenseActiveDto;

    public function __construct(
        private readonly QueryBusInterface $query,
    ) {
        $this->listLicenseActiveDto = new ArrayCollection();
        $this->listLicenseActiveDto = $this->query->handle(new ListLicenseActiveDtoQuery(new \DateTime()));
        $this->periodDate = sprintf(
            '%s - %s',
            $this->listLicenseActiveDto->first()->startYear,
            $this->listLicenseActiveDto->first()->endYear
        );
    }

    public function getLicencesInPeriod(): ArrayCollection
    {
        return $this->listLicenseActiveDto;
    }

    public function getPeriodDate(): string
    {
        return $this->periodDate;
    }
}
