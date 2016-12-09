<?php

namespace Nayjest\Querying\Handler\PhpArray;

use Nayjest\Querying\Handler\AbstractFactory;
use Nayjest\Querying\Handler\PostProcess\FilterHandler;
use Nayjest\Querying\Handler\PostProcess\PaginateHandler;
use Nayjest\Querying\Handler\PostProcess\SortHandler;
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