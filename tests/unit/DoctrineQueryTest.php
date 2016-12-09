<?php

namespace  Nayjest\Querying\Test;

use Nayjest\Querying\DoctrineQuery;

class DoctrineQueryTest extends AbstracDatabaseQueryTest
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    public function setUp()
    {
        $this->connection = doctrine_connection();
    }

    protected function data()
    {
        return array_data();
    }

    protected function query()
    {
        return $this->connection->createQueryBuilder()->select('*')->from('test_users');
    }

    public function make($src = null)
    {
        if ($src === null) {
            $src = $this->query();
        }
        return new DoctrineQuery($src);
    }
}
