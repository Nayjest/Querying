<?php

namespace Nayjest\Querying;

use ArrayIterator;
use Exception;
use Nayjest\Querying\Handler\AbstractFactory;
use Nayjest\Querying\Handler\HandlerInterface;
use Nayjest\Querying\Operation\InitializeRowsOperation;
use Nayjest\Querying\Operation\OperationInterface;
use Nayjest\Querying\Row\DynamicFieldsRegistry;
use Nayjest\Querying\Row\RowInterface;

abstract class AbstractQuery implements QueryInterface
{
    private $dataSource;
    /**
     * @var OperationInterface[]
     */
    private $operations;

    private $dynamicFields;

    /**
     * @return AbstractFactory
     */
    abstract protected function getHandlerFactory();

    /**
     * AbstractQuery constructor.
     * @param $dataSource
     * @param string $rowClass
     */
    public function __construct($dataSource, $rowClass)
    {
        $this->dataSource = $dataSource;
        $this->dynamicFields = new DynamicFieldsRegistry();
        $this->operations = [new InitializeRowsOperation($rowClass, $this->dynamicFields)];
    }

    public function getIterator()
    {
        $data = $this->get();
        if (is_array($data)) {
            return new ArrayIterator($data);
        } else {
            return $data;
        }
    }

    /**
     * @param $data
     * @return RowInterface[]|\Traversable
     */
    protected function execute($data)
    {
        foreach ($this->getHandlers() as $handler) {
            $data = $handler->apply($data);
        }
        return $data;
    }

    /**
     * @return HandlerInterface[]
     */
    protected function getHandlers()
    {
        $handlers = [];
        $factory = $this->getHandlerFactory();
        foreach ($this->operations as $operation) {
            $handlers[] = $factory->makeHandler($operation);
        }
        usort($handlers, function (HandlerInterface $a, HandlerInterface $b) {
            $aPos = $a->getPriority();
            $bPos = $b->getPriority();
            if ($aPos == $bPos) {
                return 0;
            }
            return ($aPos < $bPos) ? 1 : -1;
        });
        return $handlers;
    }

    /**
     * @return RowInterface[]
     */
    public function getArray()
    {
        $data = $this->get();
        return is_array($data) ? $data : iterator_to_array($data);
    }

    /**
     * @return RowInterface[]|\Traversable
     */
    public function get()
    {
        return $this->execute($this->dataSource);
    }

    public function getRaw()
    {
        $res = [];
        foreach ($this->get() as $row) {
            $res[] = $row->extract();
        }
        return $res;
    }

    /**
     * @param OperationInterface $operation
     * @return $this
     */
    public function addOperation(OperationInterface $operation)
    {
        $this->operations[] = $operation;
        return $this;
    }

    public function addOperations(array $operations)
    {
        foreach ($operations as $operation) {
            $this->addOperation($operation);
        }
        return $this;
    }

    public function hasOperation(OperationInterface $operation)
    {
        return in_array($operation, $this->operations);
    }

    public function removeOperation(OperationInterface $operation)
    {
        if ($this->hasOperation($operation)) {
            $key = array_search($operation, $this->operations);
            unset($this->operations[$key]);
        } else {
            throw new Exception("Trying to remove unexisting operation from query");
        }
        return $this;
    }

    /**
     * @return Operation\OperationInterface[]
     */
    public function getOperations()
    {
        return $this->operations;
    }

    public function getSrc()
    {
        return $this->dataSource;
    }
}
