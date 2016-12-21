<?php

namespace Nayjest\Querying\Row;

interface RowInterface
{
    public function get($fieldName, $default = null);
    public function has($fieldName);

    /**
     * @return DynamicFieldsRegistry
     */
    public function dynamicFieldsRegistry();
    public function getSrc();
    public function extract();
    public function toArray();
    public function toObject();
}
