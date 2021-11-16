<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ContentTag;

/**
 * @link https://www.w3.org/TR/html52/textlevel-semantics.html#the-b-element
 */
final class B extends ContentTag
{
    protected function getName(): string
    {
        return 'b';
    }
}
