<?php

namespace App\Twig\Components;

use App\Dto\LicenceActiveDto;
use App\Enum\LicenseTypeEnum;
use App\Repository\LicensePeriodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class LicensesActiveComponent
{
    private string $periodDate;
    private ArrayCollection $listLicenseActiveDto;

    public function __construct(
        private readonly LicensePeriodRepository $licensePeriodRepository,
    ) {
        $this->listLicenseActiveDto = new ArrayCollection();
        $licensesActive = $this->licensePeriodRepository->getLicensePeriodActiveByDate(new \DateTime());
        if (null !== $licensesActive) {
            $this->periodDate = sprintf('%s - %s', $licensesActive[0]['startDate']->format('Y'), $licensesActive[0]['endDate']->format('Y'));
            foreach ($licensesActive as $licenseActive) {
                $licenceActiveDto = $this->hasLicenseActiveDtoType($licenseActive['type']);
                if (null === $licenceActiveDto) {
                    $licenceActiveDto = new LicenceActiveDto($licenseActive);
                    $this->listLicenseActiveDto->add($licenceActiveDto);
                }
                $licenceActiveDto->addDetail($licenseActive['label']);
            }
        }
    }

    public function getLicencesInPeriod(): ArrayCollection
    {
        return $this->listLicenseActiveDto;
    }

    public function getPeriodDate(): string
    {
        return $this->periodDate;
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
