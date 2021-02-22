<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://www.w3.org/TR/html52/textlevel-semantics.html#the-span-element
 */
final class Span extends NormalTag
{
    protected function getName(): string
    {
        return 'span';
    }
}
