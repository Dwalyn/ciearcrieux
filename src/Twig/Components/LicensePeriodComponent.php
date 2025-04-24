<?php

namespace App\Twig\Components;

use App\Entity\LicensePeriod;
use App\Query\QueryBusInterface;

abstract class LicensePeriodComponent
{
    protected ?LicensePeriod $licensePeriod = null;
    protected bool $showDetails = true;

    protected \DateTime $startDate;
    protected \DateTime $endDate;

    public function __construct(
        protected readonly QueryBusInterface $query,
    ) {
    }

    public function mount(?LicensePeriod $licensePeriod = null, bool $showDetails = true): void
    {
        $this->licensePeriod = $licensePeriod;
        $this->showDetails = $showDetails;
        $this->defineLimitDate();
    }

    public function getShowDetails(): bool
    {
        return $this->showDetails;
    }

    protected function defineLimitDate(): void
    {
        if (null !== $this->licensePeriod) {
            $this->startDate = $this->licensePeriod->getStartDate();
            $this->endDate = $this->licensePeriod->getEndDate();
        } else {
            $currentDate = (new \DateTime())->format('md');
            if ($currentDate < '0901') {
                $startYear = ((int) (new \DateTime())->format('Y')) - 1;
                $endYear = ((int) (new \DateTime())->format('Y'));
            } else {
                $startYear = ((int) (new \DateTime())->format('Y'));
                $endYear = ((int) (new \DateTime())->format('Y')) + 1;
            }
            $this->startDate = new \DateTime(sprintf('%s-09-01', $startYear));
            $this->endDate = new \DateTime(sprintf('%s-08-31', $endYear));
        }
    }
}
