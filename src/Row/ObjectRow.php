<?php

namespace Nayjest\Querying\Row;

class ObjectRow extends AbstractRow
{
    private $data;

    public function __construct(DynamicFieldsRegistry $dynamicFields, $data)
    {
        if (!is_object($data)) {
            throw new \InvalidArgumentException;
        }
        $this->data = $data;
        parent::__construct($dynamicFields);
    }


    /**
     * @return object
     */
    public function getSrc()
    {
        return $this->data;
    }

    public function getInternal($fieldName)
    {
        return $this->data->{$fieldName};
    }

    public function hasInternal($fieldName)
    {
        return isset($this->data->{$fieldName});
    }
}
