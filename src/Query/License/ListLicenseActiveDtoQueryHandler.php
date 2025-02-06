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
    /**
     * @var ArrayCollection<int, LicenceActiveDto>
     */
    private ArrayCollection $listLicenseActiveDto;

    public function __construct(
        private readonly LicensePeriodRepository $licensePeriodRepository,
    ) {
    }

    /**
     * @return ArrayCollection<int, LicenceActiveDto>|null
     */
    public function __invoke(ListLicenseActiveDtoQuery $query): ?ArrayCollection
    {
        $this->listLicenseActiveDto = new ArrayCollection();
        $licensesActive = $this->licensePeriodRepository->getLicenceInLicensePeriodActiveByDate($query->date);
        if (null !== $licensesActive) {
            foreach ($licensesActive as $licenseActive) {
                $licenceActiveDto = $this->hasLicenseActiveDtoType($licenseActive['type']);
                if (null === $licenceActiveDto) {
                    $licenceActiveDto = new LicenceActiveDto(
                        $licenseActive['startDate'],
                        $licenseActive['endDate'],
                        $licenseActive['type'],
                        $licenseActive['price'],
                    );
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

        if ($result->count() && $result->first() instanceof LicenceActiveDto) {
            return $result->first();
        }

        return null;
    }
}
