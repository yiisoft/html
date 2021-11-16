<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ContentTag;

/**
 * @link https://www.w3.org/TR/html52/textlevel-semantics.html#the-strong-element
 */
final class Strong extends ContentTag
{
    protected function getName(): string
    {
        return 'strong';
    }
}
