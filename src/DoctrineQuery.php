<?php

namespace Nayjest\Querying;

use Doctrine\DBAL\Query\QueryBuilder;
use Nayjest\Querying\Exception\ManualInterruptProcessingException;
use Nayjest\Querying\Handler\DoctrineDBAL\Factory;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\CustomOperation;
use Nayjest\Querying\Row\ObjectRow;
use PDO;

class DoctrineQuery extends AbstractQuery
{

    public function __construct(QueryBuilder $dataSource)
    {
        parent::__construct($dataSource, ObjectRow::class);
    }

    /**
     * @return QueryBuilder;
     */
    public function getReadyQuery()
    {
        $readyQuery = null;
        $this->addOperation(
            new CustomOperation(function (QueryBuilder $query) use (&$readyQuery) {
                $readyQuery = $query;
                throw new ManualInterruptProcessingException;
            }, Priority::HYDRATE - 2)
        );
        try {
            $this->get();
        } catch (ManualInterruptProcessingException $e) {
        }
        return $readyQuery;
    }

    public function getSQL()
    {
        return $this->getReadyQuery()->getSQL();
    }

    protected function initialize()
    {
        $this->addOperations(
            [
                new CustomOperation(function (QueryBuilder $query) {
                    return $query->execute()->fetchAll(PDO::FETCH_OBJ);
                }, Priority::HYDRATE - 1),

                // Clone query to avoid applying same query modifications multiple times
                // when executing ->get() / ->getSql() multiple times.
                new CustomOperation(function (QueryBuilder $query) {
                    return clone($query);
                }, Priority::PREPARE - 1),
            ]
        );
    }

    protected function getHandlerFactory()
    {
        return new Factory();
    }
}