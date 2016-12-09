<?php

namespace Nayjest\Querying\Handler\PostProcess;

use InvalidArgumentException;
use Nayjest\Querying\Handler\AbstractHandler;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\FilterOperation;
use Nayjest\Querying\RowInterface;

/**
 * Class FilterHandler
 */
class FilterHandler extends AbstractHandler
{
    const PRIORITY = Priority::POST_PROCESS;

    public function getPriority()
    {
        return self::PRIORITY;
    }
    /**
     * Applies operation to source and returns modified source.
     *
     */
    public function apply($dataSource)
    {
        /** @var FilterOperation $operation */
        $operation = $this->operation;
        foreach ($dataSource as $row) {
            /** @var RowInterface $row */
            $testedValue = $row->get($operation->getField());
            $argument = $operation->getValue();
            $operator = $operation->getOperator();
            if ($this->checkValue($testedValue, $operator, $argument)) {
                yield $row;
            }
        }
    }

    /**
     * @param $testedValue
     * @param string $operator
     * @param $argument
     * @return bool
     * @throws InvalidArgumentException
     *
     */
    protected function checkValue($testedValue, $operator, $argument)
    {
        switch ($operator) {
            case FilterOperation::OPERATOR_EQ:
                return $testedValue == $argument;
            case FilterOperation::OPERATOR_GT:
                return $testedValue > $argument;
            case FilterOperation::OPERATOR_GTE:
                return $testedValue >= $argument;
            case FilterOperation::OPERATOR_LT:
                return $testedValue < $argument;
            case FilterOperation::OPERATOR_LTE:
                return $testedValue <= $argument;
            case FilterOperation::OPERATOR_NOT_EQ:
                return $testedValue != $argument;
            case FilterOperation::OPERATOR_STR_CONTAINS:
                return strpos($testedValue, $argument) !== false;
            case FilterOperation::OPERATOR_STR_STARTS_WITH:
                return strpos($testedValue, $argument) === 0;
            case FilterOperation::OPERATOR_STR_ENDS_WITH:
                return strpos($testedValue, $argument, strlen($testedValue) - strlen($argument)) !== false;
            default:
                throw new InvalidArgumentException(
                    'Unsupported operator ' . $operator
                );
        }
    }
}
