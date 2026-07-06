<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/text-level-semantics.html#the-sub-and-sup-elements
 */
final class Sub extends NormalTag
{
    use TagContentTrait;

    protected function getName(): string
    {
        return 'sub';
    }
}
