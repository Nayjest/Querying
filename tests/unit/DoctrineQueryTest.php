<?php

namespace  Nayjest\Querying\Test;

use Doctrine\DBAL\Query\QueryBuilder;
use Nayjest\Querying\ArrayQuery;
use Nayjest\Querying\DoctrineQuery;
use Nayjest\Querying\Operation\AddFieldOperation;
use Nayjest\Querying\Operation\DummyOperation;
use Nayjest\Querying\Operation\FilterOperation;
use Nayjest\Querying\Operation\PaginateOperation;
use Nayjest\Querying\Operation\SortOperation;
use Nayjest\Querying\Row\ArrayRow;
use Nayjest\Querying\Row\ObjectRow;
use Nayjest\Querying\Row\RowInterface;
use PHPUnit_Framework_TestCase;

class DoctrineQueryTest extends PHPUnit_Framework_TestCase
{

    private $data;
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    public function setUp()
    {
        $this->data = array_data();
        $this->connection = doctrine_connection();
    }

    protected function query()
    {
        return $this->connection->createQueryBuilder()->select('*')->from('test_users');
    }

    protected function make(QueryBuilder $src)
    {
        return new DoctrineQuery($src);
    }

    public function testGetAll()
    {
        $q = $this->make($this->query());
        $data = $q->getArray();
        self::assertEquals(count($this->data), count($data));
    }

    public function testGetCombined()
    {
        $q = $this->make($this->query());
        $q->addOperations([
            new FilterOperation('id', FilterOperation::OPERATOR_LTE, 20),
            new FilterOperation('id', FilterOperation::OPERATOR_NOT_EQ, 14),
            new SortOperation('id', 'desc'),
            new PaginateOperation(2,5)
        ]);

        $data = $q->getArray();
        self::assertTrue($data[0]->get('id') == 15);
        self::assertTrue($data[1]->get('id') == 13);
        self::assertEquals(5, count($data));
    }
}