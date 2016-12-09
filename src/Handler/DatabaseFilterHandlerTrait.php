<?php

namespace Nayjest\Querying\Handler;

use Nayjest\Querying\Operation\FilterOperation;

trait DatabaseFilterHandlerTrait
{
    abstract protected function getOperation();

    protected function getOperatorAndValue()
    {
        /** @var  FilterOperation $operation */
        $operation = $this->getOperation();
        $operator = $operation->getOperator();
        $value = $operation->getValue();
        switch ($operator) {
            case FilterOperation::OPERATOR_STR_STARTS_WITH:
                $operator = FilterOperation::OPERATOR_LIKE;
                $value .= '%';
                break;
            case FilterOperation::OPERATOR_STR_ENDS_WITH:
                $operator = FilterOperation::OPERATOR_LIKE;
                $value = '%' . $value;
                break;
            case FilterOperation::OPERATOR_STR_CONTAINS:
                $operator = FilterOperation::OPERATOR_LIKE;
                $value = '%' . $value . '%';
                break;
        }
        return [$operator, $value];
    }
}
