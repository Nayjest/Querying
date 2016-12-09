<?php

namespace Nayjest\Querying\Row;

class ArrayRow extends AbstractRow
{
    private $data;

    public function __construct(DynamicFieldsRegistry $dynamicFields, array $data)
    {
        $this->data = $data;
        parent::__construct($dynamicFields);
    }

    /**
     * @return array
     */
    public function getSrc()
    {
        return $this->data;
    }

    protected function getInternal($fieldName)
    {
        return $this->data[$fieldName];
    }

    protected function hasInternal($fieldName)
    {
        return array_key_exists($fieldName, $this->data);
    }
}
