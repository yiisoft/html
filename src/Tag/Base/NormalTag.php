<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

abstract class NormalTag extends ContentTag
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

    final protected function renderTag(): string
    {
        return $this->open() . $this->generateContent() . $this->close();
    }
}
