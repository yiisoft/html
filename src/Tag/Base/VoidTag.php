<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

abstract class VoidTag extends Tag
{
    final private function __construct()
    {
    }

    /**
     * @return static
     */
    final public static function tag(): self
    {
        return new static();
    }

    final public function render(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }
}
