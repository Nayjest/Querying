<?php

namespace Nayjest\Querying\Handler\Eloquent;

use Nayjest\Querying\Handler\AbstractDatabaseFilterHandler;

use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\FilterOperation;
use Illuminate\Database\Eloquent\Builder;

/**
 * FilterOperation processing for DoctrineDataProvider.
 *
 * @see FilterOperation
 */
class FilterHandler extends AbstractDatabaseFilterHandler
{
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
