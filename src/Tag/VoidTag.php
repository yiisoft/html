<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Html;

abstract class VoidTag extends Tag
{
    final public function __toString(): string
    {
        return '<' . $this->getName() . Html::renderTagAttributes($this->attributes) . '>';
    }
}
