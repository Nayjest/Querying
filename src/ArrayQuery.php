<?php

namespace Nayjest\Querying;

use Nayjest\Querying\Handler\PhpArray\Factory;

class ArrayQuery extends AbstractQuery
{
    protected function getHandlerFactory()
    {
        return new Factory();
    }

    public function count()
    {
        return count($this->getArray());
    }
}
