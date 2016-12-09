<?php
namespace Nayjest\Querying\Operation;

use Nayjest\Querying\Row\ArrayRow;

class AddRowOperation implements OperationInterface
{
    /**
     * @var
     */
    private $src;

    /**
     * @var
     */
    private $rowClass;

    public static function fromArray(array $src)
    {
        return new static($src, ArrayRow::class);
    }

    public function __construct($src, $rowClass)
    {
        $this->src = $src;
        $this->rowClass = $rowClass;
    }

    public function getSrc()
    {
        return $this->src;
    }

    public function getRowClass()
    {
        return $this->rowClass;
    }
}
