<?php

namespace Nayjest\Querying;


use Exception;
use Nayjest\Querying\Exception\ManualInterruptProcessingException;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\CloneOperation;
use Nayjest\Querying\Operation\CustomOperation;
use Nayjest\Querying\Operation\FetchOperation;
use Nayjest\Querying\Operation\SortOperation;

abstract class AbstractDatabaseQuery extends AbstractQuery
{
    abstract public function getSQL();
    abstract protected function getCountInternal();

    /**
     * AbstractDatabaseQuery constructor.
     * @param $dataSource
     * @param string $rowClass
     */
    public function __construct($dataSource, $rowClass)
    {
        parent::__construct($dataSource, $rowClass);
        $this->addOperations(
            [
                new CloneOperation(),
                new FetchOperation(),
            ]
        );
    }

    /**
     * Returns query builder with all database operations applied.
     *
     * @return object
     * @throws Exception
     */
    protected function getReadyQuery()
    {

        $readyQuery = null;
        $operation = new CustomOperation(
            function ($query) use (&$readyQuery) {
                $readyQuery = $query;
                throw new ManualInterruptProcessingException;
            },
            // before fetch
            Priority::FETCH + 1
        );
        $this->addOperation($operation);
        try {
            $this->get();
        } catch (ManualInterruptProcessingException $e) {
            // This exception is expected, don't needs further processing
        }
        $this->removeOperation($operation);
        if (!is_object($readyQuery)) {
            throw new Exception("Failed to interrupt processing for extracting query object.");
        }
        return $readyQuery;
    }

    /**
     * @return int
     */
    public function count()
    {
        $removed = [];
        /** remove sorting because it will produce invalid SQL that fails on Postgres
         * @see https://github.com/view-components/view-components/issues/33
         */
        foreach ($this->getOperations() as $operation) {
            if ($operation instanceof SortOperation) {
                $this->removeOperation($operation);
                $removed[] = $operation;
            }
        }
        $count = $this->getCountInternal();
        $this->addOperations($removed);
        return $count;
    }
}
