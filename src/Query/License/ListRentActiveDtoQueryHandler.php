<?php

namespace App\Query\License;

use App\Dto\License\RentActiveDto;
use App\Query\QueryHandlerInterface;
use App\Repository\LicensePeriodRepository;
use Doctrine\Common\Collections\ArrayCollection;

class ListRentActiveDtoQueryHandler implements QueryHandlerInterface
{
    private ArrayCollection $listRentActiveDto;

    public function __construct(
        private readonly LicensePeriodRepository $licensePeriodRepository,
    ) {
    }

    public function __invoke(ListRentActiveDtoQuery $query): ?ArrayCollection
    {
        $this->listRentActiveDto = new ArrayCollection();
        $rentsActive = $this->licensePeriodRepository->getRentInLicensePeriodActiveByDate($query->date);
        if (null !== $rentsActive) {
            foreach ($rentsActive as $rentActive) {
                $rentActiveDto = new RentActiveDto($rentActive);
                $this->listRentActiveDto->add($rentActiveDto);
            }
        } else {
            return null;
        }

        return $this->listRentActiveDto;
    }
}
