<?php

namespace Nayjest\Querying;

use Illuminate\Database\Query\Builder;
use Nayjest\Querying\Exception\ManualInterruptProcessingException;
use Nayjest\Querying\Handler\Eloquent\Factory;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\CustomOperation;
use Nayjest\Querying\Row\ObjectRow;

class EloquentQuery extends AbstractQuery
{
    public function __construct(Builder $dataSource)
    {
        parent::__construct($dataSource, ObjectRow::class);
    }

    /**
     * @return Builder;
     */
    public function getReadyQuery()
    {
        $readyQuery = null;
        $this->addOperation(
            new CustomOperation(function (Builder $query) use (&$readyQuery) {
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
        return $this->getReadyQuery()->toSql();
    }

    protected function initialize()
    {
        $this->addOperations(
            [
                new CustomOperation(function (Builder $query) {
                    return $query->get();
                }, Priority::HYDRATE - 1),

                // Clone query to avoid applying same query modifications multiple times
                // when executing ->get() / ->getSql() multiple times.
                new CustomOperation(function (Builder $query) {
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