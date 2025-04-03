<?php

namespace App\Repository;

use App\Entity\LicensePeriod;
use App\Trait\QueryBuilder\DateConditionTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function getLicenceInLicensePeriodActiveByDate(\DateTime $startDate, \DateTime $endDate): ?array
    {
        $queryBuilder = $this->createQueryBuilder('period');
        $queryBuilder
            ->select('period.startDate', 'period.endDate')
            ->addSelect('license.type')
            ->addSelect('license.price')
            ->addSelect('licenseDetail.label')
            ->innerJoin('period.licenses', 'license')
            ->innerJoin('license.licenseDetails', 'licenseDetail')
        ;
        $this->beetweenDate2($queryBuilder, $startDate, $endDate, 'period');
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
        $queryBuilder = $this->createQueryBuilder('period');
        $queryBuilder
            ->select('rent.type')
            ->addSelect('rent.price')
            ->innerJoin('period.rents', 'rent')
        ;
        $this->beetweenDate($queryBuilder, $date, 'period');

        $result = $queryBuilder->getQuery()->getResult();
        if (count($result)) {
            return $result;
        }

        return null;
    }
}
