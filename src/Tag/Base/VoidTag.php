<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

abstract class VoidTag extends Tag
{
    final public function render(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }
}
