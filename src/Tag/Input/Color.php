<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Input;

use Yiisoft\Html\Tag\Base\InputTag;

/**
 * @link https://html.spec.whatwg.org/multipage/input.html#color-state-(type=color)
 */
final class Color extends InputTag
{
    protected function prepareAttributes(): void
    {
        $this->attributes['type'] = 'color';
    }
}
