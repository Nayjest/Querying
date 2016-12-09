<?php

namespace Nayjest\Querying\Handler\PostProcess;

use Nayjest\Querying\Handler\AbstractHandler;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\AddFieldOperation;
use Nayjest\Querying\Row\RowInterface;

class AddFieldHandler extends AbstractHandler
{
    const PRIORITY = Priority::POST_PROCESS_BEGIN;

    public function getPriority()
    {
        return self::PRIORITY;
    }
    /**
     * Applies operation to source and returns modified source.
     *
     */
    public function apply($dataSource)
    {
        /** @var AddFieldOperation $operation */
        $operation = $this->operation;
        foreach ($dataSource as $row) {
            /** @var RowInterface $row */
            $row->dynamicFieldsRegistry()->add(
                $operation->getFieldName(),
                $operation->getCallable()
            );
            return $dataSource;
        }
    }
}
