<?php

namespace Nayjest\Querying\Operation;

use Nayjest\Querying\Row\DynamicFieldsRegistry;

class HydrateOperation implements OperationInterface
{
    /**
     * @var string
     */
    private $rowClass;
    /**
     * @var DynamicFieldsRegistry
     */
    private $dynamicFields;

    public function __construct($rowClass, DynamicFieldsRegistry $dynamicFields)
    {

        $this->rowClass = $rowClass;
        $this->dynamicFields = $dynamicFields;
    }

    /**
     * @return string
     */
    public function getRowClass()
    {
        return $this->rowClass;
    }

    /**
     * @return DynamicFieldsRegistry
     */
    public function getDynamicFields()
    {
        return $this->dynamicFields;
    }
}