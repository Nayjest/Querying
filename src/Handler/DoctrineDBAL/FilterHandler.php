<?php

namespace Nayjest\Querying\Handler\DoctrineDBAL;

use Nayjest\Querying\Handler\AbstractDatabaseFilterHandler;

use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\FilterOperation;
use Doctrine\DBAL\Query\QueryBuilder;

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
     * @param QueryBuilder $src
     * @return QueryBuilder
     */
    public function apply($src)
    {
        /** @var FilterOperation $operation */
        $operation = $this->operation;
        list($operator, $value) = $this->getOperatorAndValue();
        $fieldName = $operation->getField();
        $parameterName = 'p'. md5($fieldName . $operator);
        $src->andWhere("$fieldName $operator :$parameterName");
        $src->setParameter($parameterName, $value);
        return $src;
    }
}
