<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\TableCellTag;

/**
 * @link https://www.w3.org/TR/html52/tabular-data.html#the-td-element
 */
final class Td extends TableCellTag
{
    protected function getName(): string
    {
        return 'td';
    }
}
