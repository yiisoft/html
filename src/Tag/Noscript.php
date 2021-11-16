<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ContentTag;

/**
 * @link https://html.spec.whatwg.org/multipage/scripting.html#the-noscript-element
 */
final class Noscript extends ContentTag
{
    protected function getName(): string
    {
        return 'noscript';
    }
}
