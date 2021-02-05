<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

abstract class ContainerTag extends Tag
{
    final public function __toString(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>' .
            $this->generateContent() .
            '</' . $this->getName() . '>';
    }

    abstract protected function generateContent(): string;
}
