<?php

namespace Nayjest\Querying\Handler\Doctrine;

use Nayjest\Querying\Handler\AbstractHandler;
use Nayjest\Querying\Handler\DatabaseFilterHandlerTrait;
use Nayjest\Querying\Operation\FilterOperation;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * FilterOperation handler for Doctrine.
 *
 * @see FilterOperation
 */
class FilterHandler extends AbstractHandler
{
    use DatabaseOperationHandlerTrait;
    use DatabaseFilterHandlerTrait;

    /**
     * @param QueryBuilder $queryBuilder
     */
    protected function applyInternal(QueryBuilder $queryBuilder)
    {
        /** @var FilterOperation $operation */
        $operation = $this->operation;
        list($operator, $value) = $this->getOperatorAndValue();
        $fieldName = $operation->getField();
        $parameterName = 'p' . md5($fieldName . $operator);
        $queryBuilder->andWhere("$fieldName $operator :$parameterName");
        $queryBuilder->setParameter($parameterName, $value);
    }
}
