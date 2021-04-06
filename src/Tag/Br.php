<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://www.w3.org/TR/html52/textlevel-semantics.html#the-br-element
 */
final class Br extends VoidTag
{
    protected function getName(): string
    {
        return 'br';
    }
}
