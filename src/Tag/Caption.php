<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ContentTag;

/**
 * @link https://www.w3.org/TR/html52/tabular-data.html#the-caption-element
 */
final class Caption extends ContentTag
{
    protected function getName(): string
    {
        return 'caption';
    }
}
