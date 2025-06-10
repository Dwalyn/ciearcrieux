<?php

namespace App\Repository;

use App\Entity\TrainingPlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<TrainingPlace>
 *
 * @method TrainingPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingPlace|null findOneBy(mixed[] $criteria, mixed[] $orderBy = null)
 * @method TrainingPlace[] findAll()
 * @method TrainingPlace[] findBy(mixed[] $criteria, mixed[] $orderBy = null, $limit = null, $offset = null)
 */
class TrainingPlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingPlace::class);
    }
}
