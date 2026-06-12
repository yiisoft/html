<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ListTag;

/**
 * @link https://html.spec.whatwg.org/multipage/grouping-content.html#the-menu-element
 */
final class Menu extends ListTag
{
    protected function getName(): string
    {
        return 'menu';
    }
}
