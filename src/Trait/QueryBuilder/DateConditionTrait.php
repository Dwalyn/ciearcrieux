<?php

namespace App\Trait\QueryBuilder;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\QueryBuilder;

trait DateConditionTrait
{
    public function beetweenDate(QueryBuilder $queryBuilder, \DateTime $date, string $tableAlias): QueryBuilder
    {
        $queryBuilder
            ->andWhere($queryBuilder->expr()->lte(sprintf('%s.startDate', $tableAlias), ':date'))
            ->andWhere($queryBuilder->expr()->gte(sprintf('%s.endDate', $tableAlias), ':date'))
            ->setParameter(':date', $date)
        ;

        return $queryBuilder;
    }

    public function beetweenDate2(QueryBuilder $queryBuilder, \DateTime $startDate, \DateTime $endDate, string $tableAlias): QueryBuilder
    {
        $queryBuilder
            ->andWhere($queryBuilder->expr()->gte(sprintf('%s.startDate', $tableAlias), ':startDate'))
            ->andWhere($queryBuilder->expr()->lte(sprintf('%s.endDate', $tableAlias), ':endDate'))
            ->setParameters(new ArrayCollection([
                new Parameter('startDate', $startDate->setTime(0, 0)),
                new Parameter('endDate', $endDate->setTime(23, 59)),
            ]))
        ;

        return $queryBuilder;
    }
}
