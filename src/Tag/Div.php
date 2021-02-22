<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://www.w3.org/TR/html52/grouping-content.html#the-div-element
 */
final class Div extends NormalTag
{
    protected function getName(): string
    {
        return 'div';
    }
}
