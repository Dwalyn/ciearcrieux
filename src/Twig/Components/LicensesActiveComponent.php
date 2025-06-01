<?php

namespace App\Twig\Components;

use App\Dto\License\LicenceActiveDto;
use App\Query\JoinUs\ListLicenseActiveDtoQuery;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class LicensesActiveComponent extends LicensePeriodComponent
{
    /**
     * @return ArrayCollection<int, LicenceActiveDto>|null
     */
    public function getLicencesInPeriod(): ?ArrayCollection
    {
        return $this->query->handle(new ListLicenseActiveDtoQuery($this->licensePeriod));
    }
}
