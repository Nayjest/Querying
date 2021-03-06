<?php

namespace Nayjest\Querying;

use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use Nayjest\Querying\Handler\Doctrine\Factory;
use Nayjest\Querying\Row\ObjectRow;

class DoctrineQuery extends AbstractDatabaseQuery
{
    public function __construct(QueryBuilder $dataSource)
    {
        parent::__construct($dataSource, ObjectRow::class);
    }

    /**
     * @return QueryBuilder
     * @throws Exception
     */
    public function getDoctrineQuery()
    {
        return $this->getReadyQuery();
    }
    /**
     * @return string
     * @throws Exception
     */
    public function getSQL()
    {
        return $this->getDoctrineQuery()->getSQL();
    }

    /**
     * @return int
     */
    protected function getCountInternal()
    {
        return (int)$this
            ->getDoctrineQuery()
            ->select('count(*) as row_count')
            ->execute()
            ->fetchColumn();
    }

    protected function getHandlerFactory()
    {
        return new Factory();
    }
}
