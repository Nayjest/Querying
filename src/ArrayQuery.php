<?php

namespace Nayjest\Querying;

use Nayjest\Querying\Handler\PhpArray\Factory;
use Nayjest\Querying\Row\ArrayRow;

class ArrayQuery extends AbstractQuery
{
    protected function getHandlerFactory()
    {
        return new Factory();
    }
}