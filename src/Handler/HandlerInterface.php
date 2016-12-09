<?php

namespace Nayjest\Querying\Handler;

use Nayjest\Querying\Operation\OperationInterface;

interface HandlerInterface
{
    public function __construct(OperationInterface $operation);
    public function getPriority();
    public function apply($dataSource);
}
