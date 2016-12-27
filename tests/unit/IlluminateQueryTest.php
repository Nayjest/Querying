<?php

namespace  Nayjest\Querying\Test;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Query\Builder;
use Nayjest\Querying\IlluminateQuery;

class IlluminateQueryTest extends AbstracDatabaseQueryTest
{
    /**
     * @var \Illuminate\Database\Connection
     */
    private $connection;

    public function setUp()
    {
        $this->connection = Manager::connection();
    }

    /**
     * @return Builder
     */
    protected function query()
    {
        return $this->connection->query()->from('test_users');
    }

    public function make($src = null)
    {
        if ($src === null) {
            $src = $this->query();
        }
        return new IlluminateQuery($src);
    }
}
