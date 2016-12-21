<?php

namespace Nayjest\Querying\Test;


use Nayjest\Querying\Row\DynamicFieldsRegistry;
use Nayjest\Querying\Row\RowInterface;

abstract class AbstractRowTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param DynamicFieldsRegistry $registry
     * @return RowInterface
     */
    abstract protected function make(DynamicFieldsRegistry $registry);


    public function test()
    {
        $registry = new DynamicFieldsRegistry();
        $registry->add('dyn_field', function (RowInterface $row) {
            return $row->get('test_field', 0) + 1;
        });
        $row = $this->make($registry);
        self::assertTrue($row->has('test_field'));
        self::assertTrue($row->has('dyn_field'));
        self::assertFalse($row->has('abs_field'));
        self::assertEquals(7, $row->get('test_field'));
        self::assertEquals(8, $row->get('dyn_field'));

        $obj = $row->toObject();
        self::assertTrue($obj->test_field === 7);
        self::assertTrue($obj->dyn_field === 8);
        $arr = $row->toArray();
        self::assertTrue($arr['test_field'] === 7);
        self::assertTrue($arr['dyn_field'] === 8);
        self::assertTrue(count($arr) === 2);


    }

}