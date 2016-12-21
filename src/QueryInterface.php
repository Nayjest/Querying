<?php

namespace Nayjest\Querying;

use IteratorAggregate;
use Nayjest\Querying\Operation\OperationInterface;

interface QueryInterface extends IteratorAggregate
{
    public function get();

    public function getRaw();

    public function getArray();

    public function getIterator();

    public function addOperation(OperationInterface $operation);

    public function addOperations(array $operations);

    public function hasOperation(OperationInterface $operation);

    public function removeOperation(OperationInterface $operation);

    public function getSrc();
}
