<?php

namespace App\Repository;

use App\Entity\LicensePeriod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<LicensePeriod>
 *
 * @method LicensePeriod|null find($id, $lockMode = null, $lockVersion = null)
 * @method LicensePeriod|null findOneBy(array $criteria, array $orderBy = null)
 * @method LicensePeriod[] findAll()
 * @method LicensePeriod[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicensePeriodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LicensePeriod::class);
    }

    public function getLicensePeriodActiveByDate(\DateTime $date): ?array
    {
        $queryBuilder = $this->createQueryBuilder('licensePeriod');
        $queryBuilder
            ->select('licensePeriod.startDate', 'licensePeriod.endDate')
            ->addSelect('license.type')
            ->addSelect('license.price')
            ->addSelect('licenseDetail.label')
            ->innerJoin('licensePeriod.licenses', 'license')
            ->innerJoin('license.licenseDetails', 'licenseDetail')
            ->andWhere($queryBuilder->expr()->lte('licensePeriod.startDate', ':date'))
            ->andWhere($queryBuilder->expr()->gte('licensePeriod.endDate', ':date'))
            ->setParameter(':date', $date)
        ;
        $result = $queryBuilder->getQuery()->getResult();
        if (count($result)) {
            return $result;
        }

        return null;
    }
}
