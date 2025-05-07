<?php

namespace App\Trait\QueryBuilder;

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
}
