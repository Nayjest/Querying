<?php

namespace Nayjest\Querying\Row;

use Exception;

class DynamicFieldsRegistry
{
    private $dynamicFields = [];

    public function add($name, callable $fn)
    {
        if ($this->has($name)) {
            throw new Exception("Dynamic field $name already defined");
        }
        $this->set($name, $fn);
    }

    public function set($name, callable $fn)
    {
        $this->dynamicFields[$name] = $fn;
    }

    public function has($name)
    {
        return array_key_exists($name, $this->dynamicFields);
    }

    public function get($name, RowInterface $row)
    {
        return call_user_func($this->dynamicFields[$name], $row);
    }

    public function getAll(RowInterface $row)
    {
        $res = [];
        foreach(array_keys($this->dynamicFields) as $name) {
            $res[$name] = $this->get($name, $row);
        }
        return $res;
    }
}
