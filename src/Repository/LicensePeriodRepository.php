<?php

namespace App\Repository;

use App\Entity\LicensePeriod;
use App\Enum\TimeStatusEnum;
use App\Trait\QueryBuilder\DateConditionTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Order;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<LicensePeriod>
 *
 * @method LicensePeriod|null find($id, $lockMode = null, $lockVersion = null)
 * @method LicensePeriod|null findOneBy(mixed[] $criteria, mixed[] $orderBy = null)
 * @method LicensePeriod[] findAll()
 * @method LicensePeriod[] findBy(mixed[] $criteria, mixed[] $orderBy = null, $limit = null, $offset = null)
 */
class LicensePeriodRepository extends ServiceEntityRepository
{
    use DateConditionTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LicensePeriod::class);
    }

    /**
     * @return array<int, mixed>|null
     */
    public function getLicenceInLicensePeriodActive(): ?array
    {
        $queryBuilder = $this->createQueryBuilder('period');
        $queryBuilder
            ->select('period.startDate', 'period.endDate')
            ->addSelect('license.type')
            ->addSelect('license.price')
            ->addSelect('licenseDetail.label')
            ->innerJoin('period.licenses', 'license')
            ->innerJoin('license.licenseDetails', 'licenseDetail')
            ->where($queryBuilder->expr()->eq('period.status', ':status'))
            ->setParameter('status', TimeStatusEnum::IN_PROGRESS)
        ;
        $result = $queryBuilder->getQuery()->getResult();
        if (count($result)) {
            return $result;
        }

        return null;
    }

    /**
     * @return array<int, mixed>|null
     */
    public function getRentInLicensePeriodActive(): ?array
    {
        $queryBuilder = $this->createQueryBuilder('period');
        $queryBuilder
            ->select('rent.type')
            ->addSelect('rent.price')
            ->innerJoin('period.rents', 'rent')
            ->where($queryBuilder->expr()->eq('period.status', ':status'))
            ->setParameter('status', TimeStatusEnum::IN_PROGRESS)
        ;

        $result = $queryBuilder->getQuery()->getResult();
        if (count($result)) {
            return $result;
        }

        return null;
    }

    public function getLastPeriod(): ?LicensePeriod
    {
        $queryBuilder = $this->createQueryBuilder('period');

        $queryBuilder
            ->orderBy('period.endDate', Order::Descending->value)
            ->setMaxResults(1)
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
