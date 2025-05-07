<?php

namespace App\Repository;

use App\Entity\LicenseDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<LicenseDetail>
 *
 * @method LicenseDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method LicenseDetail|null findOneBy(mixed[] $criteria, mixed[] $orderBy = null)
 * @method LicenseDetail[] findAll()
 * @method LicenseDetail[] findBy(mixed[] $criteria, mixed[] $orderBy = null, $limit = null, $offset = null)
 */
class LicenseDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LicenseDetail::class);
    }

    /**
     * @param array<int> $licenseDetailsIds,
     *
     * @return array<int, LicenseDetail>
     */
    public function findByIds(array $licenseDetailsIds): array
    {
        $queryBuilder = $this->createQueryBuilder('licenseDetail');

        $queryBuilder
            ->where($queryBuilder->expr()->in('licenseDetail.id', ':licenseDetailsIds'))
            ->setParameter('licenseDetailsIds', $licenseDetailsIds)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
