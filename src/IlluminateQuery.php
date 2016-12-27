<?php

namespace Nayjest\Querying;

use Exception;
use Illuminate\Database\Query\Builder;
use Nayjest\Querying\Handler\Illuminate\Factory;
use Nayjest\Querying\Row\ObjectRow;

class IlluminateQuery extends AbstractDatabaseQuery
{
    public function __construct(Builder $dataSource)
    {
        parent::__construct($dataSource, ObjectRow::class);
    }

    /**
     * @return Builder
     * @throws Exception
     */
    public function getIlluminateQuery()
    {
        return $this->getReadyQuery();
    }

    /**
     * @return string
     */
    public function getSQL()
    {
        return $this->getIlluminateQuery()->toSql();
    }

    /**
     * @return int
     */
    protected function getCountInternal()
    {
        return $this->getIlluminateQuery()->count();
    }

    protected function getHandlerFactory()
    {
        return new Factory();
    }
}
