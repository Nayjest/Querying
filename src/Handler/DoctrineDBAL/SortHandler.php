<?php

namespace Nayjest\Querying\Handler\DoctrineDBAL;

use Nayjest\Querying\Handler\AbstractHandler;
use Nayjest\Querying\Handler\Priority;
use Doctrine\DBAL\Query\QueryBuilder;
use Nayjest\Querying\Operation\SortOperation;

/**
 * SortOperation processing for DoctrineDataProvider.
 *
 * @see SortOperation
 */
class SortHandler extends AbstractHandler
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
        /** @var SortOperation $operation */
        $operation = $this->operation;
        $field = $operation->getField();
        $order = $operation->getOrder();
        $src->orderBy($field, $order);
        return $src;
    }
}
