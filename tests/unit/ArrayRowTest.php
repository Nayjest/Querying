<?php

namespace  Nayjest\Querying\Test;

use Nayjest\Querying\ArrayQuery;
use Nayjest\Querying\Row\ArrayRow;
use Nayjest\Querying\Row\DynamicFieldsRegistry;
use PHPUnit_Framework_TestCase;

class ArrayRowTest extends PHPUnit_Framework_TestCase
{

    public function test()
    {
        $row = new ArrayRow(new DynamicFieldsRegistry(), ['test_field' => 7]);
        self::assertTrue($row->has('test_field'));
        self::assertEquals(7, $row->get('test_field'));
    }
}