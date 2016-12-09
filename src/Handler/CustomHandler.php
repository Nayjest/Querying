<?php

namespace Nayjest\Querying\Handler;

/**
 * Class CustomHandler
 *
 * @property \Nayjest\Querying\Operation\CustomOperation $operation
 */
class CustomHandler extends AbstractHandler
{
    public function getPriority()
    {
        return $this->operation->getPriority();
    }

    public function apply($dataSource)
    {
        return call_user_func($this->operation->getHandler(), $dataSource);
    }
}