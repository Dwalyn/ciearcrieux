<?php

namespace App\Repository;

use App\Entity\TrainingDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<TrainingDay>
 *
 * @method TrainingDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingDay|null findOneBy(mixed[] $criteria, mixed[] $orderBy = null)
 * @method TrainingDay[] findAll()
 * @method TrainingDay[] findBy(mixed[] $criteria, mixed[] $orderBy = null, $limit = null, $offset = null)
 */
class TrainingDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingDay::class);
    }
}
