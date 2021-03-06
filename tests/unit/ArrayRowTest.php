<?php

namespace Nayjest\Querying\Test;

use Nayjest\Querying\Row\ArrayRow;
use Nayjest\Querying\Row\DynamicFieldsRegistry;

class ArrayRowTest extends AbstractRowTest
{
    protected function make(DynamicFieldsRegistry $r)
    {
        return new ArrayRow($r, ['test_field' => 7]);
    }
}
