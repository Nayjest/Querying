<?php

namespace Nayjest\Querying\Handler\Illuminate;

use Nayjest\Querying\Handler\AbstractHandler;
use Nayjest\Querying\Handler\DatabaseFilterHandlerTrait;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\FilterOperation;
use Illuminate\Database\Eloquent\Builder;

/**
 * FilterOperation processing for DoctrineDataProvider.
 *
 * @see FilterOperation
 */
class FilterHandler extends AbstractHandler
{
    use DatabaseFilterHandlerTrait;

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
        /** @var FilterOperation $operation */
        $operation = $this->operation;
        list($operator, $value) = $this->getOperatorAndValue();
        $fieldName = $operation->getField();
        $src->where($fieldName, $operator, $value);
        return $src;
    }
}
