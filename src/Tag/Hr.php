<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://html.spec.whatwg.org/multipage/grouping-content.html#the-hr-element
 */
final class Hr extends VoidTag
{
    protected function getName(): string
    {
        return 'hr';
    }
}
