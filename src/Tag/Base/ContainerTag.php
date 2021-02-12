<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

abstract class ContainerTag extends Tag
{
    final public function render(): string
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
