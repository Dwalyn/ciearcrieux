<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function loadUserByIdentifier(string $usernameOrEmail): ?User
    {
        $queryBuilder = $this->createQueryBuilder('User');

        $queryBuilder
            ->where($queryBuilder->expr()->eq('User.email', ':email'))
            ->andWhere($queryBuilder->expr()->eq('User.enable', ':enable'))
            ->setParameters(new ArrayCollection([
                new Parameter('email', $usernameOrEmail),
                new Parameter('enable', true),
            ]))
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Used to upgrade (rehash) the User's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @return array<User>
     */
    public function findBySearchFilter(string $searchFilter): array
    {
        $queryBuilder = $this->createQueryBuilder('User');

        $queryBuilder
            ->where($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('User.lastname', ':searchFilter'),
                $queryBuilder->expr()->like('User.firstname', ':searchFilter'),
                $queryBuilder->expr()->like('User.licenseNumber', ':searchFilter'),
                $queryBuilder->expr()->like('User.email', ':searchFilter'),
            ))
            ->orderBy('User.lastname', Order::Ascending->value)
            ->setParameters(new ArrayCollection([
                new Parameter('searchFilter', '%'.$searchFilter.'%'),
            ]))
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
