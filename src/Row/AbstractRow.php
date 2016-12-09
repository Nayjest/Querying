<?php

namespace Nayjest\Querying\Row;

abstract class AbstractRow implements RowInterface
{
    protected $dynamicFields;

    abstract protected function hasInternal($fieldName);

    abstract protected function getInternal($fieldName);

    public function __construct(DynamicFieldsRegistry $dynamicFields)
    {
        $this->dynamicFields = $dynamicFields;
    }

    public function get($fieldName, $default = null)
    {
        return $this->hasInternal($fieldName) ? $this->getInternal($fieldName) : (
            $this->dynamicFields->has($fieldName) ? $this->dynamicFields->get($fieldName, $this) : $default
        );
    }

    public function has($fieldName)
    {
        return $this->hasInternal($fieldName) || $this->dynamicFields->has($fieldName);
    }

    public function dynamicFieldsRegistry()
    {
        return $this->dynamicFields;
    }
}
