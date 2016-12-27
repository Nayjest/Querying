<?php

namespace Nayjest\Querying\Handler;

class CloneHandler extends AbstractHandler
{
    public function getPriority()
    {
        return Priority::CLONING;
    }

    public function apply($dataSource)
    {
        return clone($dataSource);
    }
}
