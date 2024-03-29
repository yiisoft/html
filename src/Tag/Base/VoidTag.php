<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

/**
 * Base for all void tags.
 * Void tags are immediately self-closed and have no content.
 */
abstract class VoidTag extends Tag
{
    final private function __construct()
    {
    }

    final public static function tag(): static
    {
        return new static();
    }

    final protected function renderTag(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }
}
