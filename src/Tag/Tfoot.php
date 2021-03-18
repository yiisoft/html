<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\TableRowsContainerTag;

/**
 * @link https://www.w3.org/TR/html52/tabular-data.html#the-tfoot-element
 */
final class Tfoot extends TableRowsContainerTag
{
    protected function getName(): string
    {
        return 'tfoot';
    }
}
