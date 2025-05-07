<?php

namespace App\Twig\Components;

use App\Entity\LicensePeriod;
use App\Query\QueryBusInterface;

abstract class LicensePeriodComponent
{
    protected ?LicensePeriod $licensePeriod = null;
    protected bool $showDetails = true;

    public function __construct(
        protected readonly QueryBusInterface $query,
    ) {
    }

    public function mount(?LicensePeriod $licensePeriod = null, bool $showDetails = true): void
    {
        $this->licensePeriod = $licensePeriod;
        $this->showDetails = $showDetails;
    }

    public function getShowDetails(): bool
    {
        return $this->showDetails;
    }
}
