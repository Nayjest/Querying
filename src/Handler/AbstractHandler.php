<?php

namespace Nayjest\Querying\Handler;

use Nayjest\Querying\Operation\OperationInterface;

abstract class AbstractHandler implements HandlerInterface
{
    /** @var  OperationInterface */
    protected $operation;

    public function __construct(OperationInterface $operation)
    {
        $this->operation = $operation;
    }

    abstract public function apply($dataSource);

    abstract public function getPriority();

    /**
     * @return OperationInterface
     */
    protected function getOperation()
    {
        return $this->operation;
    }
}
