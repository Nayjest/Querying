<?php

namespace Nayjest\Querying\Handler\DoctrineDBAL;

use Nayjest\Querying\Handler\AbstractPaginateHandler;
use Nayjest\Querying\Operation\PaginateOperation;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * PaginateOperation handler for Doctrine.
 *
 * @see PaginateOperation
 */
class PaginateHandler extends AbstractPaginateHandler
{
    use DatabaseOperationHandlerTrait;

    /**
     * @param QueryBuilder $queryBuilder
     */
    protected function applyInternal(QueryBuilder $queryBuilder)
    {
        /** @var PaginateOperation $operation */
        $operation = $this->operation;
        $queryBuilder
            ->setFirstResult($this->getOffset($operation))
            ->setMaxResults($operation->getPageSize());
    }
}
