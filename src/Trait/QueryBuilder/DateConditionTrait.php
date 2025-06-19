<?php

namespace App\Trait\QueryBuilder;

use Doctrine\ORM\QueryBuilder;

trait DateConditionTrait
{
    public function beetweenDate(QueryBuilder $queryBuilder, \DateTime $date, string $tableAlias): QueryBuilder
    {
        $queryBuilder
            ->andWhere($queryBuilder->expr()->gte(sprintf('%s.startDate', $tableAlias), ':startdate'))
            ->andWhere($queryBuilder->expr()->lte(sprintf('%s.endDate', $tableAlias), ':enddate'))
            ->setParameter('startdate', (clone $date)->setTime(0, 0))
            ->setParameter('enddate', (clone $date)->setTime(23, 59, 59))
        ;

        return $queryBuilder;
    }

    public function toDayBeetweenDate(QueryBuilder $queryBuilder, string $tableAlias): QueryBuilder
    {
        $queryBuilder
            ->andWhere($queryBuilder->expr()->lte(sprintf('%s.startDate', $tableAlias), ':startdate'))
            ->andWhere($queryBuilder->expr()->gte(sprintf('%s.endDate', $tableAlias), ':enddate'))
            ->setParameter('startdate', (new \DateTime())->setTime(0, 0))
            ->setParameter('enddate', (new \DateTime())->setTime(23, 59, 59))
        ;

        return $queryBuilder;
    }
}
