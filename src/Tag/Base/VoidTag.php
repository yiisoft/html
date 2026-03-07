<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Deprecated;

/**
 * Base for all void tags.
 * Void tags are immediately self-closed and have no content.
 */
abstract class VoidTag extends Tag
{
    final public function __construct() {}

    #[Deprecated('Use the constructor instead.')]
    final public static function tag(): static
    {
        return new static();
    }

    final protected function renderTag(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }
}
