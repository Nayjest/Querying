<?php
namespace Nayjest\Querying\Operation;

class AddFieldOperation implements OperationInterface
{
    /**
     * @var
     */
    private $fieldName;
    /**
     * @var callable
     */
    private $fn;

    public function __construct($fieldName, callable $fn)
    {
        $this->fieldName = $fieldName;
        $this->fn = $fn;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return callable
     */
    public function getCallable()
    {
        return $this->fn;
    }
}
