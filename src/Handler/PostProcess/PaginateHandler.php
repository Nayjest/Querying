<?php

namespace Nayjest\Querying\Handler\PostProcess;

use Nayjest\Querying\Handler\AbstractPaginateHandler;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\PaginateOperation;

class PaginateHandler extends AbstractPaginateHandler
{
    public function getPriority()
    {
        return Priority::POST_PROCESS - 4;
    }

    public function apply($dataSource)
    {
        /** @var PaginateOperation $operation */
        $operation = $this->operation;
        /**
         * @todo optimise for generators
         */
        if (!is_array($dataSource)) {
            $dataSource = iterator_to_array($dataSource);
        }
        return array_slice(
            $dataSource,
            $this->getOffset($operation),
            $operation->getPageSize()
        );
    }
}
