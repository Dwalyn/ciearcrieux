<?php

namespace App\Query\JoinUs;

use App\Dto\License\RentActiveDto;
use App\Query\QueryHandlerInterface;
use App\Repository\LicensePeriodRepository;
use Doctrine\Common\Collections\ArrayCollection;

class ListRentActiveDtoQueryHandler implements QueryHandlerInterface
{
    /**
     * @var ArrayCollection<int, RentActiveDto>
     */
    private ArrayCollection $listRentActiveDto;

    public function __construct(
        private readonly LicensePeriodRepository $licensePeriodRepository,
    ) {
    }

    /**
     * @return ArrayCollection<int, RentActiveDto>|null
     */
    public function __invoke(ListRentActiveDtoQuery $query): ?ArrayCollection
    {
        $this->listRentActiveDto = new ArrayCollection();
        if (null === $query->licensePeriod) {
            $rentsActive = $this->licensePeriodRepository->getRentInLicensePeriodActive();
        } else {
            $rentsActive = $this->licensePeriodRepository->getRentInLicensePeriod($query->licensePeriod);
        }

        if (null !== $rentsActive) {
            foreach ($rentsActive as $rentActive) {
                $rentActiveDto = new RentActiveDto(
                    $rentActive['type'],
                    $rentActive['price']
                );
                $this->listRentActiveDto->add($rentActiveDto);
            }

            return $this->listRentActiveDto;
        }

        return null;
    }
}
