<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\TableCellTag;

/**
 * @link https://www.w3.org/TR/html52/tabular-data.html#the-th-element
 */
final class Th extends TableCellTag
{
    protected function getName(): string
    {
        return 'th';
    }
}
