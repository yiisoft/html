<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

/**
 * Base for container tags such as lists and select.
 */
abstract class ContainerTag extends Tag
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
        return $this->begin() . $this->generateContent() . $this->end();
    }

    final public function begin(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }

    final public function end(): string
    {
        return '</' . $this->getName() . '>';
    }

    abstract protected function generateContent(): string;
}
