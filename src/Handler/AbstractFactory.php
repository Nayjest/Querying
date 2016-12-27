<?php

namespace Nayjest\Querying\Handler;

use InvalidArgumentException;

use Nayjest\Querying\Handler\PostProcess\AddFieldHandler;
use Nayjest\Querying\Operation\AddFieldOperation;
use Nayjest\Querying\Operation\CloneOperation;
use Nayjest\Querying\Operation\CustomOperation;
use Nayjest\Querying\Operation\DummyOperation;
use Nayjest\Querying\Operation\InitializeRowsOperation;
use Nayjest\Querying\Operation\OperationInterface;

abstract class AbstractFactory
{
    /**
     * @return array
     */
    abstract protected function getRegisteredHandlers();

    protected function getDefaultHandlers()
    {
        return [
            DummyOperation::class => DummyHandler::class,
            InitializeRowsOperation::class => InitializeRowsHandler::class,
            AddFieldOperation::class => AddFieldHandler::class,
            CustomOperation::class => CustomHandler::class,
            CloneOperation::class => CloneHandler::class,
        ];
    }

    final protected function getHandlers()
    {
        return array_merge(
            $this->getDefaultHandlers(),
            $this->getRegisteredHandlers()
        );
    }

    public function makeHandler(OperationInterface $operation)
    {
        $operationClass = get_class($operation);
        $classes = $this->getHandlers();
        if (array_key_exists($operationClass, $classes)) {
            $handlerClass = $classes[$operationClass];
            return new $handlerClass($operation);
        }
        throw new InvalidArgumentException("No handler for '$operationClass' operation.");
    }
}
