<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

/**
 * Base for all normal tags. Normal tags are the ones that have both opening tag and closing tag.
 */
abstract class NormalTag extends Tag
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

    /**
     * @return string Opening tag.
     */
    final public function open(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>' . $this->prepend();
    }

    protected function prepend(): string
    {
        return '';
    }

    /**
     * @return string Closing tag.
     */
    final public function close(): string
    {
        return '</' . $this->getName() . '>';
    }

    abstract protected function generateContent(): string;
}
