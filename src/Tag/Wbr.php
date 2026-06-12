<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://html.spec.whatwg.org/multipage/text-level-semantics.html#the-wbr-element
 */
final class Wbr extends VoidTag
{
    protected function getName(): string
    {
        return 'wbr';
    }
}
