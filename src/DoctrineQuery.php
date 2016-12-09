<?php

namespace Nayjest\Querying;

use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
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
     * @return QueryBuilder
     * @throws Exception
     */
    public function getReadyQuery()
    {
        /** @var QueryBuilder $readyQuery */
        $readyQuery = null;
        $operation = new CustomOperation(
            function (QueryBuilder $query) use (&$readyQuery) {
                $readyQuery = $query;
                throw new ManualInterruptProcessingException;
            },
            Priority::HYDRATE - 2
        );
        $this->addOperation($operation);
        try {
            $this->get();
        } catch (ManualInterruptProcessingException $e) {
        }
        $this->removeOperation($operation);
        if (!$readyQuery instanceof QueryBuilder) {
            throw new Exception("Failed to interrupt processing for extracting query object.");
        }
        return $readyQuery;
    }

    /**
     * @return string
     * @throws Exception
     */
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