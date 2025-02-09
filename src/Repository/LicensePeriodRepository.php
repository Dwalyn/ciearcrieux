<?php

namespace App\Repository;

use App\Entity\LicensePeriod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LicensePeriod::class);
    }

    /**
     * @return array<int, mixed>|null
     */
    public function getLicenceInLicensePeriodActiveByDate(\DateTime $date): ?array
    {
        $queryBuilder = $this->createQueryBuilder('licensePeriod');
        $queryBuilder
            ->select('licensePeriod.startDate', 'licensePeriod.endDate')
            ->addSelect('license.type')
            ->addSelect('license.price')
            ->addSelect('licenseDetail.label')
            ->innerJoin('licensePeriod.licenses', 'license')
            ->innerJoin('license.licenseDetails', 'licenseDetail')
        ;
        $this->periodCondition($queryBuilder, $date);

        $result = $queryBuilder->getQuery()->getResult();
        if (count($result)) {
            return $result;
        }

        return null;
    }

    /**
     * @return array<int, mixed>|null
     */
    public function getRentInLicensePeriodActiveByDate(\DateTime $date): ?array
    {
        $queryBuilder = $this->createQueryBuilder('licensePeriod');
        $queryBuilder
            ->select('rent.type')
            ->addSelect('rent.price')
            ->innerJoin('licensePeriod.rents', 'rent')
        ;
        $this->periodCondition($queryBuilder, $date);

        $result = $queryBuilder->getQuery()->getResult();
        if (count($result)) {
            return $result;
        }

        return null;
    }

    private function periodCondition(QueryBuilder $queryBuilder, \DateTime $date): QueryBuilder
    {
        $queryBuilder
            ->andWhere($queryBuilder->expr()->lte('licensePeriod.startDate', ':date'))
            ->andWhere($queryBuilder->expr()->gte('licensePeriod.endDate', ':date'))
            ->setParameter(':date', $date)
        ;

        return $queryBuilder;
    }
}
