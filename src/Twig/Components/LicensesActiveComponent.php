<?php

namespace App\Twig\Components;

use App\Dto\License\LicenceActiveDto;
use App\Entity\LicensePeriod;
use App\Query\JoinUs\ListLicenseActiveDtoQuery;
use App\Query\QueryBusInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class LicensesActiveComponent
{
    private ?LicensePeriod $licensePeriod = null;

    public function mount(?LicensePeriod $licensePeriod = null): void
    {
        $this->licensePeriod = $licensePeriod;
    }

    public function __construct(
        private readonly QueryBusInterface $query,
    ) {
    }

    /**
     * @return ArrayCollection<int, LicenceActiveDto>|null
     */
    public function getLicencesInPeriod(): ?ArrayCollection
    {
        if (null !== $this->licensePeriod) {
            $startDate = $this->licensePeriod->getStartDate();
            $endDate = $this->licensePeriod->getEndDate();
        } else {
            $currentDate = (new \DateTime())->format('md');
            if ($currentDate < '0901') {
                $startYear = ((int) (new \DateTime())->format('Y')) - 1;
                $endYear = ((int) (new \DateTime())->format('Y'));
            } else {
                $startYear = ((int) (new \DateTime())->format('Y'));
                $endYear = ((int) (new \DateTime())->format('Y')) + 1;
            }
            $startDate = new \DateTime(sprintf('%s-09-01', $startYear));
            $endDate = new \DateTime(sprintf('%s-08-31', $endYear));
        }

        return $this->query->handle(new ListLicenseActiveDtoQuery($startDate, $endDate));
    }
}
