<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

abstract class VoidTag extends Tag
{
    final public function __toString(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }
}
