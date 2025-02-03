<?php

namespace App\Query\License;

use App\Dto\License\LicenceActiveDto;
use App\Enum\LicenseTypeEnum;
use App\Query\QueryHandlerInterface;
use App\Repository\LicensePeriodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class ListLicenseActiveDtoQueryHandler implements QueryHandlerInterface
{
    private ArrayCollection $listLicenseActiveDto;

    public function __construct(
        private readonly LicensePeriodRepository $licensePeriodRepository,
    ) {
    }

    public function __invoke(ListLicenseActiveDtoQuery $query): ?ArrayCollection
    {
        $this->listLicenseActiveDto = new ArrayCollection();
        $licensesActive = $this->licensePeriodRepository->getLicenceInLicensePeriodActiveByDate($query->date);
        if (null !== $licensesActive) {
            foreach ($licensesActive as $licenseActive) {
                $licenceActiveDto = $this->hasLicenseActiveDtoType($licenseActive['type']);
                if (null === $licenceActiveDto) {
                    $licenceActiveDto = new LicenceActiveDto($licenseActive);
                    $this->listLicenseActiveDto->add($licenceActiveDto);
                }
                $licenceActiveDto->addDetail($licenseActive['label']);
            }
        } else {
            return null;
        }

        return $this->listLicenseActiveDto;
    }

    private function hasLicenseActiveDtoType(LicenseTypeEnum $licenseTypeEnum): ?LicenceActiveDto
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('type', $licenseTypeEnum))
        ;
        $result = $this->listLicenseActiveDto->matching($criteria);

        if ($result->count()) {
            return $result->first();
        }

        return null;
    }
}
