<?php

namespace Nayjest\Querying\Test;

use Nayjest\Querying\Row\ArrayRow;
use Nayjest\Querying\Row\DynamicFieldsRegistry;
use Nayjest\Querying\Row\ObjectRow;

class ObjectRowTest extends AbstractRowTest
{
    protected function make(DynamicFieldsRegistry $r)
    {
        return new ObjectRow($r, (object)['test_field' => 7]);
    }
}
