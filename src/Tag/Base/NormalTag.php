<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

abstract class NormalTag extends BaseNormalTag
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
        return $this->begin() . $this->generateContent() . $this->end();
    }
}
