<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ContentTag;

/**
 * @link https://html.spec.whatwg.org/multipage/semantics.html#the-title-element
 */
final class Title extends ContentTag
{
    protected function getName(): string
    {
        return 'title';
    }
}
