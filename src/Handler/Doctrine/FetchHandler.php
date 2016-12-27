<?php

namespace Nayjest\Querying\Handler\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Nayjest\Querying\Handler\AbstractHandler;
use Nayjest\Querying\Handler\Priority;
use PDO;

class FetchHandler extends AbstractHandler
{
    /**
     * @param QueryBuilder $dataSource
     * @return mixed
     */
    public function apply($dataSource)
    {
        return $dataSource->execute()->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPriority()
    {
        return Priority::FETCH;
    }
}
