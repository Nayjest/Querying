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

    public function toArray()
    {
        return array_merge((array)$this->getSrc(), $this->dynamicFieldsRegistry()->getAll($this));
    }

    public function toObject()
    {
        $src = $this->getSrc();
        if (!is_object($src)) {
            $src = (object)$src;
        }
        $dynamicFields = $this->dynamicFieldsRegistry()->getAll($this);
        foreach($dynamicFields as $key => $value) {
            $src->{$key} = $value;
        }
        return $src;
    }

    public function extract()
    {
        return is_array($this->getSrc()) ? $this->toArray() : $this->toObject();
    }
}
