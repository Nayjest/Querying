<?php
namespace Nayjest\Querying\Operation;

class CustomOperation implements OperationInterface
{

    /**
     * @var callable
     */
    private $handler;
    /**
     * @var int
     */
    private $priority;

    public function __construct(callable $handler, $priority)
    {

        $this->handler = $handler;
        $this->priority = $priority;
    }

    /**
     * @return callable
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
