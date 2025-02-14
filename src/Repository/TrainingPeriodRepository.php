<?php

namespace App\Repository;

use App\Entity\TrainingPeriod;
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
            ->where($queryBuilder->expr()->eq('trainingPeriod.active', ':active'))
            ->andWhere($queryBuilder->expr()->eq('trainingPeriod.typePlaceEnum', ':typePlaceEnum'))
            ->setParameters(new ArrayCollection([
                new Parameter('active', true),
                new Parameter('typePlaceEnum', $typePlaceEnum),
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
}
