<?php

namespace Nayjest\Querying\Handler\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Nayjest\Querying\Handler\Priority;

trait DatabaseOperationHandlerTrait
{
    abstract protected function applyInternal(QueryBuilder $queryBuilder);

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
