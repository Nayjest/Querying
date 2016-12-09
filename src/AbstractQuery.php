<?php

namespace Nayjest\Querying;

use Exception;
use Nayjest\Querying\Handler\AbstractFactory;
use Nayjest\Querying\Handler\HandlerInterface;
use Nayjest\Querying\Operation\HydrateOperation;
use Nayjest\Querying\Operation\OperationInterface;
use Nayjest\Querying\Row\DynamicFieldsRegistry;
use Nayjest\Querying\Row\RowInterface;

abstract class AbstractQuery
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
        $this->operations = [new HydrateOperation($rowClass, $this->dynamicFields)];
        $this->initialize();
    }

    protected function initialize()
    {

    }

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
            return ($aPos < $bPos) ? -1 : 1;
        });
        return $handlers;
    }

    /**
     * @return RowInterface[]|\Traversable
     */
    public function get()
    {
        return $this->execute($this->dataSource);
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
     * @return array
     */
    public function getRaw()
    {
        $data = $this->get();
        $res = [];
        foreach ($data as $row) {
            $res[] = $row->getSrc();
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

    public function getSrc()
    {
        return $this->dataSource;
    }
}
