<?php

namespace Nayjest\Querying\Handler;


use Nayjest\Querying\Operation\PaginateOperation;

abstract class AbstractPaginateHandler extends AbstractHandler
{
    protected function getOffset(PaginateOperation $operation)
    {
        return ($operation->getPageNumber() - 1) * $operation->getPageSize();
    }
}
