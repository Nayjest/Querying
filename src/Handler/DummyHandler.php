<?php

namespace Nayjest\Querying\Handler;

class DummyHandler extends AbstractHandler
{
    public function getPriority()
    {
        return Priority::MAIN;
    }

    public function apply($dataSource)
    {
        return $dataSource;
    }
}