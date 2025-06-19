<?php

namespace App\Repository;

use App\Entity\LicensePeriod;
use App\Entity\TrainingPeriod;
use App\Enum\TimeStatusEnum;
use App\Enum\TypePlaceEnum;
use App\Trait\QueryBuilder\DateConditionTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<TrainingPeriod>
 *
 * @method TrainingPeriod|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingPeriod|null findOneBy(mixed[] $criteria, mixed[] $orderBy = null)
 * @method TrainingPeriod[] findAll()
 * @method TrainingPeriod[] findBy(mixed[] $criteria, mixed[] $orderBy = null, $limit = null, $offset = null)
 */
class TrainingPeriodRepository extends ServiceEntityRepository
{
    use DateConditionTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingPeriod::class);
    }

    /**
     * @return array<int, mixed>|null
     */
    public function getTrainingPeriodActive(TypePlaceEnum $typePlaceEnum): ?array
    {
        $queryBuilder = $this->createQueryBuilder('trainingPeriod');

        $queryBuilder
            ->select('trainingPeriod.startDate', 'trainingPeriod.endDate', 'trainingPeriod.typePlaceEnum')
            ->addSelect('trainingPlace.id as trainingPlaceId', 'trainingPlace.name', 'trainingPlace.city', 'trainingPlace.cityNumber', 'trainingPlace.adress', 'trainingPlace.googleMapUrl')
            ->addSelect('trainingDay.day', 'trainingDay.startTime', 'trainingDay.endTime', 'trainingDay.licensedType')
            ->innerJoin('trainingPeriod.trainingPlace', 'trainingPlace')
            ->innerJoin('trainingPeriod.trainingDays', 'trainingDay')
            ->innerJoin('trainingPeriod.licensePeriod', 'licensePeriod')
            ->where($queryBuilder->expr()->eq('trainingPeriod.typePlaceEnum', ':typePlaceEnum'))
            ->andWhere($queryBuilder->expr()->eq('licensePeriod.status', ':status'))
            ->setParameters(new ArrayCollection([
                new Parameter('typePlaceEnum', $typePlaceEnum),
                new Parameter('status', TimeStatusEnum::IN_PROGRESS->value),
            ]))
        ;
        if (TypePlaceEnum::OUTDOOR === $typePlaceEnum) {
            $queryBuilder = $this->toDayBeetweenDate($queryBuilder, 'trainingPeriod');
        }
        $result = $queryBuilder->getQuery()->getResult();
        if (count($result)) {
            return $result;
        }

        return null;
    }

    /**
     * @return array<int, mixed>|null
     */
    public function getTrainingPeriodById(string $id): ?array
    {
        $queryBuilder = $this->createQueryBuilder('trainingPeriod');

        $queryBuilder
            ->select('trainingPeriod.startDate', 'trainingPeriod.endDate', 'trainingPeriod.typePlaceEnum')
            ->addSelect('trainingPlace.id as trainingPlaceId', 'trainingPlace.name', 'trainingPlace.city', 'trainingPlace.cityNumber', 'trainingPlace.adress', 'trainingPlace.googleMapUrl')
            ->addSelect('trainingDay.day', 'trainingDay.startTime', 'trainingDay.endTime', 'trainingDay.licensedType')
            ->innerJoin('trainingPeriod.trainingPlace', 'trainingPlace')
            ->innerJoin('trainingPeriod.trainingDays', 'trainingDay')

            ->where($queryBuilder->expr()->eq('trainingPeriod.id', ':trainingPeriodId'))
            ->setParameters(new ArrayCollection([
                new Parameter('trainingPeriodId', $id),
            ]))
        ;
        $result = $queryBuilder->getQuery()->getResult();
        if (count($result)) {
            return $result;
        }

        return null;
    }

    public function getCurrentTrainingPeriod(\DateTime $date): ?TrainingPeriod
    {
        $queryBuilder = $this->createQueryBuilder('trainingPeriod');

        $queryBuilder = $this->beetweenDate($queryBuilder, $date, 'trainingPeriod');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @return array<int, mixed>|null
     */
    public function findTrainingPeriodInLicensePeriod(LicensePeriod $licensePeriod): ?array
    {
        $queryBuilder = $this->createQueryBuilder('trainingPeriod');

        $queryBuilder
            ->select('trainingPeriod.id')
            ->where($queryBuilder->expr()->eq('trainingPeriod.licensePeriod', ':licencePeriodId'))
            ->setParameters(new ArrayCollection([
                new Parameter('licencePeriodId', $licensePeriod->getId()),
            ]))
        ;

        $result = $queryBuilder->getQuery()->getSingleColumnResult();
        if (count($result)) {
            return $result;
        }

        return null;
    }

    public function getPreviousTrainingPeriod(TrainingPeriod $trainingPeriod): TrainingPeriod
    {
        $queryBuilder = $this->createQueryBuilder('trainingPeriod');

        $queryBuilder
            ->innerJoin('trainingPeriod.licensePeriod', 'licensePeriod')
            ->where($queryBuilder->expr()->eq('trainingPeriod.endDate', ':endDate'))
            ->andWhere($queryBuilder->expr()->eq('licensePeriod.id', ':idLicensePeriod'))
            ->setParameters(new ArrayCollection([
                new Parameter('endDate', clone ($trainingPeriod->getStartDate())->modify('-1 day')),
                new Parameter('idLicensePeriod', $trainingPeriod->getLicensePeriod()->getId()),
            ]))
        ;

        return $queryBuilder->getQuery()->getSingleResult();
    }

    public function getNextTrainingPeriod(TrainingPeriod $trainingPeriod): TrainingPeriod
    {
        $queryBuilder = $this->createQueryBuilder('trainingPeriod');

        $queryBuilder
            ->innerJoin('trainingPeriod.licensePeriod', 'licensePeriod')
            ->where($queryBuilder->expr()->eq('trainingPeriod.startDate', ':startDate'))
            ->andWhere($queryBuilder->expr()->eq('licensePeriod.id', ':idLicensePeriod'))
            ->setParameters(new ArrayCollection([
                new Parameter('startDate', clone $trainingPeriod->getEndDate()->modify('+1 day')),
                new Parameter('idLicensePeriod', $trainingPeriod->getLicensePeriod()->getId()),
            ]))
        ;

        return $queryBuilder->getQuery()->getSingleResult();
    }
}
