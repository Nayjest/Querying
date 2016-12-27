<?php

namespace Nayjest\Querying\Handler\Doctrine;

use Nayjest\Querying\Handler\AbstractHandler;
use Doctrine\DBAL\Query\QueryBuilder;
use Nayjest\Querying\Operation\SortOperation;

/**
 * SortOperation handler for Doctrine.
 *
 * @see SortOperation
 */
class SortHandler extends AbstractHandler
{
    use DatabaseOperationHandlerTrait;

    /**
     * @param QueryBuilder $queryBuilder
     */
    protected function applyInternal(QueryBuilder $queryBuilder)
    {
        /** @var SortOperation $operation */
        $operation = $this->operation;
        $queryBuilder->orderBy(
            $operation->getField(),
            $operation->getOrder()
        );
    }
}
