<?php

namespace  Nayjest\Querying\Test;

use Nayjest\Querying\ArrayQuery;
use Nayjest\Querying\Operation\AddFieldOperation;
use Nayjest\Querying\Operation\DummyOperation;
use Nayjest\Querying\Operation\FilterOperation;
use Nayjest\Querying\Operation\PaginateOperation;
use Nayjest\Querying\Operation\SortOperation;
use Nayjest\Querying\Row\ArrayRow;
use Nayjest\Querying\Row\RowInterface;
use PHPUnit_Framework_TestCase;

class ArrayQueryTest extends PHPUnit_Framework_TestCase
{
    protected function make(array $src = [], $rowClass = ArrayRow::class)
    {
        return new ArrayQuery($src, $rowClass);
    }
    public function testConstruct()
    {
        $this->make();
    }

    public function dataProvider()
    {
        return [
            [[]],
            [[
                ['id' => 1],
                ['id' => 2],
            ]],
            [[
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
                ['id' => 4],
                ['id' => 5],
                ['id' => 6],
                ['id' => 7],
                ['id' => 8],
                ['id' => 9],
                ['id' => 10],
            ]]
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCountReturnedByGet($src)
    {
        $q = $this->make($src);
        $q
            ->addOperation(new DummyOperation())
            ->addOperation(new DummyOperation());
        self::assertTrue(count($src) === count($q->getArray()));
    }

    public function testWithOperations()
    {
        $src = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
            ['id' => 4],
            ['id' => 5],
            ['id' => 6],
            ['id' => 7],
            ['id' => 8],
            ['id' => 9],
            ['id' => 10],
            ['id' => 1],
        ];
        $q = $this->make($src);
        $q->addOperations([
            new FilterOperation('id', FilterOperation::OPERATOR_LTE, 7),
            new FilterOperation('id', FilterOperation::OPERATOR_NOT_EQ, 3),
            new FilterOperation('id', FilterOperation::OPERATOR_NOT_EQ, 2),
            new AddFieldOperation('id2', function(RowInterface $row) {
                return $row->get('id') * 2;
            }),
            new SortOperation('id', 'desc'),
            new PaginateOperation(2,3)
        ]);
        $data = $q->getArray();
        self::assertTrue($data[0]->get('id2') === 8);
        self::assertTrue($data[1]->get('id2') === 2);
        self::assertTrue($data[2]->get('id2') === 2);
        self::assertTrue(count($data) === 3);
    }
}