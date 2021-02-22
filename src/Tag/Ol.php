<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ListTag;

/**
 * @link https://www.w3.org/TR/html52/grouping-content.html#the-ol-element
 */
final class Ol extends ListTag
{
    protected function getName(): string
    {
        return 'ol';
    }
}
