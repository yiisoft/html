<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://www.w3.org/TR/html52/textlevel-semantics.html#the-b-element
 */
final class B extends NormalTag
{
    use TagContentTrait;

    protected function getName(): string
    {
        return 'b';
    }
}
