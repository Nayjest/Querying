<?php

namespace Nayjest\Querying\Handler\Eloquent;

use Nayjest\Querying\Handler\AbstractPaginateHandler;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\PaginateOperation;
use Illuminate\Database\Eloquent\Builder;

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
     * @param Builder $src
     * @return Builder
     */
    public function apply($src)
    {
        /** @var PaginateOperation $operation */
        $operation = $this->operation;
        return $src->limit($operation->getPageSize())
            ->offset($this->getOffset($operation));
    }
}
