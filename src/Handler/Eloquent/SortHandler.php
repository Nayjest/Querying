<?php

namespace Nayjest\Querying\Handler\Eloquent;

use Nayjest\Querying\Handler\AbstractHandler;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\SortOperation;
use Illuminate\Database\Eloquent\Builder;

/**
 * SortOperation handler for Eloquent.
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
     * @param Builder $src
     * @return Builder
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
