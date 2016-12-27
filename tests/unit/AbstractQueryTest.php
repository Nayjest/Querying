<?php

namespace Nayjest\Querying\Test;

use Nayjest\Querying\AbstractQuery;
use Nayjest\Querying\QueryInterface;
use Nayjest\Querying\Row\RowInterface;
use PHPUnit_Framework_TestCase;

abstract class AbstractQueryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param null|mixed $data
     * @return QueryInterface
     */
    abstract public function make($data = null);

    protected function data()
    {
        return array_data();
    }

    public function testIterate()
    {
        $q = $this->make();
        self::assertInstanceOf(\IteratorAggregate::class, $q);
        self::assertInstanceOf(\Traversable::class, $q->getIterator());
        foreach($q as $item) {
            self::assertInstanceOf(RowInterface::class, $item);
        }
    }
}
