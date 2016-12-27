<?php

namespace Nayjest\Querying\Handler\Illuminate;

use Illuminate\Database\Query\Builder;
use Nayjest\Querying\Handler\Priority;

trait DatabaseOperationHandlerTrait
{
    abstract protected function applyInternal(Builder $queryBuilder);

    final public function apply($src)
    {
        $this->applyInternal($src);
        return $src;
    }

    public function getPriority()
    {
        return Priority::MAIN;
    }
}
