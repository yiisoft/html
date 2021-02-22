<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ListTag;

/**
 * @link https://www.w3.org/TR/html52/grouping-content.html#the-ul-element
 */
final class Ul extends ListTag
{
    protected function getName(): string
    {
        return 'ul';
    }
}
