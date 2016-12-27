<?php

namespace Nayjest\Querying\Handler\PostProcess;

use Nayjest\Querying\Handler\AbstractHandler;
use Nayjest\Querying\Handler\Priority;
use Nayjest\Querying\Operation\SortOperation;
use Nayjest\Querying\Row\RowInterface;

class SortHandler extends AbstractHandler
{
    public function getPriority()
    {
        return Priority::POST_PROCESS - 2;
    }

    /**
     * Applies operation to source and returns modified source.
     *
     * @param $src
     * @return mixed
     */
    public function apply($src)
    {
        /** @var SortOperation $operation */
        $operation = $this->operation;
        $field = $operation->getField();
        $desc = $operation->getOrder() === SortOperation::DESC;
        if (!is_array($src)) {
            $src = iterator_to_array($src);
        }
        usort($src, function (RowInterface $row1, RowInterface $row2) use ($field, $desc) {
            $val1 = $row1->get($field);
            $val2 = $row2->get($field);
            if ($val1 == $val2) {
                return 0;
            }
            $res = $val1 < $val2 ? -1 : 1;
            return $desc ? -$res : $res;
        });
        return $src;
    }
}
