<?php

namespace App\Query\FindUs;

use App\Dto\Training\AdressDto;
use App\Dto\Training\DayDto;
use App\Dto\Training\HourPeriodDto;
use App\Dto\Training\TrainingPlaceDto;
use App\Enum\DayEnum;
use App\Query\QueryHandlerInterface;
use App\Repository\TrainingPeriodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class TrainingActiveDtoQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly TrainingPeriodRepository $trainingPeriodRepository,
    ) {
    }

    public function __invoke(TrainingActiveDtoQuery $query): ?TrainingPlaceDto
    {
        $listTrainingPeriod = [];
        if (null !== $query->typePlaceEnum) {
            $listTrainingPeriod = $this->trainingPeriodRepository->getTrainingPeriodActive($query->typePlaceEnum);
        }
        if (null !== $query->id) {
            $listTrainingPeriod = $this->trainingPeriodRepository->getTrainingPeriodById($query->id);
        }

        if (null !== $listTrainingPeriod) {
            $trainingPlaceDto = null;
            foreach ($listTrainingPeriod as $i => $trainingPeriod) {
                if (0 === $i) {
                    $adressDto = new AdressDto(
                        $trainingPeriod['city'],
                        $trainingPeriod['cityNumber'],
                        $trainingPeriod['adress'],
                        $trainingPeriod['googleMapUrl'],
                    );

                    $trainingPlaceDto = new TrainingPlaceDto(
                        intval($trainingPeriod['trainingPlaceId']),
                        $trainingPeriod['name'],
                        $trainingPeriod['typePlaceEnum'],
                        $adressDto,
                        $trainingPeriod['startDate'],
                        $trainingPeriod['endDate'],
                    );
                }
                if (null !== $trainingPlaceDto) {
                    $dayDto = $this->hasDayDto($trainingPeriod['day'], $trainingPlaceDto->getListDayDto());
                    if (null === $dayDto) {
                        $dayDto = new DayDto($trainingPeriod['day']);
                        $trainingPlaceDto->addDayDto($dayDto);
                    }
                    $dayDto->getListHourPeriodDto()->add(new HourPeriodDto($trainingPeriod['startTime'], $trainingPeriod['endTime'], $trainingPeriod['licensedType']));
                }
            }

            return $trainingPlaceDto;
        }

        return null;
    }

    /**
     * @param ArrayCollection<int, DayDto> $listDayDto
     */
    private function hasDayDto(DayEnum $dayEnum, ArrayCollection $listDayDto): ?DayDto
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('day', $dayEnum))
        ;
        $result = $listDayDto->matching($criteria);

        if ($result->count() && $result->first() instanceof DayDto) {
            return $result->first();
        }

        return null;
    }
}
