<?php

namespace Nayjest\Querying\Handler\DoctrineDBAL;

use Nayjest\Querying\Handler\AbstractPaginateHandler;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\PaginateOperation;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * PaginateOperation processing for DoctrineDataProvider.
 *
 * @see PaginateOperation
 */
class PaginateHandler extends AbstractPaginateHandler
{
    public function getPriority()
    {
        return Priority::MAIN;
    }

    /**
     * Applies operation to data source and returns modified data source.
     *
     * @param QueryBuilder $src
     * @return QueryBuilder
     */
    public function apply($src)
    {
        /** @var PaginateOperation $operation */
        $operation = $this->operation;
        return $src
            ->setFirstResult($this->getOffset($operation))
            ->setMaxResults($operation->getPageSize());
    }
}
