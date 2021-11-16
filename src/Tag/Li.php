<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ContentTag;

/**
 * @link https://www.w3.org/TR/html52/grouping-content.html#the-li-element
 */
final class Li extends ContentTag
{
    protected function getName(): string
    {
        return 'li';
    }
}
