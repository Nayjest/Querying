<?php

namespace Nayjest\Querying\Test;

use Nayjest\Querying\Operation\FilterOperation;
use Nayjest\Querying\Operation\PaginateOperation;
use Nayjest\Querying\Operation\SortOperation;

abstract class AbstracDatabaseQueryTest extends AbstractQueryTest
{
    abstract protected function query();

    public function testGetAll()
    {
        $q = $this->make($this->query());
        $data = $q->getArray();
        self::assertEquals(count($this->data()), count($data));
    }

    public function testGetCombined()
    {
        /**
         * @var \Nayjest\Querying\DoctrineQuery|\Nayjest\Querying\EloquentQuery $q
         */
        $q = $this->make($this->query());
        $q->addOperations([
            new FilterOperation('id', FilterOperation::OPERATOR_LTE, 20),
            new FilterOperation('id', FilterOperation::OPERATOR_NOT_EQ, 14),
            new SortOperation('id', 'desc'),
            new PaginateOperation(2,5)
        ]);
        $sql = $q->getSQL();
        self::assertTrue(str_contains(strtolower($sql), [
            'select',
            'from',
            'test_users',
            'where',
            'id',
        ]));
        $data = $q->getArray();
        self::assertTrue($data[0]->get('id') == 15);
        self::assertTrue($data[1]->get('id') == 13);
        self::assertEquals(5, count($data));
    }
}
