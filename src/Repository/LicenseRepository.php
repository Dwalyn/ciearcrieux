<?php

namespace App\Repository;

use App\Entity\License;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<License>
 *
 * @method License|null find($id, $lockMode = null, $lockVersion = null)
 * @method License|null findOneBy(mixed[] $criteria, mixed[] $orderBy = null)
 * @method License[] findAll()
 * @method License[] findBy(mixed[] $criteria, mixed[] $orderBy = null, $limit = null, $offset = null)
 */
class LicenseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, License::class);
    }

    /**
     * @return array<int>
     */
    public function getIdLicenseDetails(License $license): array
    {
        $queryBuilder = $this->createQueryBuilder('license');

        $queryBuilder
            ->select('licenseDetail.id')
            ->innerJoin('license.licenseDetails', 'licenseDetail')
            ->where($queryBuilder->expr()->eq('license.id', ':licenseId'))
            ->setParameter('licenseId', $license->getId())
        ;

        return $queryBuilder->getQuery()->getSingleColumnResult();
    }
}
