<?php

namespace Nayjest\Querying\Handler\DoctrineDBAL;

use Nayjest\Querying\Handler\AbstractFactory;
use Nayjest\Querying\Operation\FilterOperation;
use Nayjest\Querying\Operation\PaginateOperation;
use Nayjest\Querying\Operation\SortOperation;

class Factory extends AbstractFactory
{
    public function getRegisteredHandlers()
    {
        return [
            FilterOperation::class => FilterHandler::class,
            SortOperation::class => SortHandler::class,
            PaginateOperation::class => PaginateHandler::class
        ];
    }
}
