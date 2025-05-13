<?php

namespace App\Query\Training;

use App\Dto\Training\TrainingInLicensePeriodDto;
use App\Query\QueryHandlerInterface;
use App\Repository\TrainingPeriodRepository;
use Doctrine\Common\Collections\ArrayCollection;

class TrainingInLicensePeriodDtoQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private TrainingPeriodRepository $trainingPeriodRepository,
    ) {
    }

    /**
     * @return ArrayCollection<int, TrainingInLicensePeriodDto>|null
     */
    public function __invoke(TrainingInLicensePeriodDtoQuery $query): ?ArrayCollection
    {
        $listTrainingInLicensePeriodDto = new ArrayCollection();
        $trainingsInLicense = $this->trainingPeriodRepository->findTrainingPeriodInLicensePeriod($query->licensePeriod);
        if (null !== $trainingsInLicense) {
            foreach ($trainingsInLicense as $trainingInLicense) {
                $trainingInLicensePeriodDto = new TrainingInLicensePeriodDto(
                    $trainingInLicense['id'],
                    $trainingInLicense['startDate'],
                    $trainingInLicense['endDate'],
                    $trainingInLicense['typePlaceEnum']
                );
                $listTrainingInLicensePeriodDto->add($trainingInLicensePeriodDto);
            }

            return $listTrainingInLicensePeriodDto;
        }

        return null;
    }
}
