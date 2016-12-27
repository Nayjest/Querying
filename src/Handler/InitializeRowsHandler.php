<?php

namespace Nayjest\Querying\Handler;

use Nayjest\Querying\Operation\InitializeRowsOperation;

class InitializeRowsHandler extends AbstractHandler
{
    const PRIORITY = Priority::INITIALIZE_ROWS;

    public function getPriority()
    {
        return self::PRIORITY;
    }

    public function apply($dataSource)
    {
        /** @var InitializeRowsOperation $operation */
        $operation = $this->operation;
        $rowClass = $operation->getRowClass();
        foreach($dataSource as $row) {
            yield new $rowClass($operation->getDynamicFields(), $row);
        }
    }
}
