<?php

namespace Nayjest\Querying\Handler\Illuminate;

use Illuminate\Database\Query\Builder;
use Nayjest\Querying\Handler\AbstractHandler;
use Nayjest\Querying\Handler\Priority;

class FetchHandler extends AbstractHandler
{
    /**
     * @param Builder $dataSource
     * @return mixed
     */
    public function apply($dataSource)
    {
        return $dataSource->get();
    }

    public function getPriority()
    {
        return Priority::FETCH;
    }
}
