<?php

namespace Nayjest\Querying\Handler;

use Nayjest\Querying\Operation\HydrateOperation;

class HydrateHandler extends AbstractHandler
{
    const PRIORITY = Priority::HYDRATE;

    public function getPriority()
    {
        return self::PRIORITY;
    }

    public function apply($dataSource)
    {
        /** @var HydrateOperation $operation */
        $operation = $this->operation;
        $rowClass = $operation->getRowClass();
        foreach($dataSource as $row) {
            yield new $rowClass($operation->getDynamicFields(), $row);
        }
    }
}
