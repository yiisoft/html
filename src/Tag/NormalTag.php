<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Html;

abstract class NormalTag extends Tag
{
    private bool $encode = true;
    private string $content = '';

    final public function withoutEncode(): self
    {
        $new = clone $this;
        $new->encode = false;
        return $new;
    }

    final public function content(string $content): self
    {
        $new = clone $this;
        $new->content = $content;
        return $new;
    }

    final public function __toString(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>' .
            ($this->encode ? Html::encode($this->content) : $this->content) .
            '</' . $this->getName() . '>';
    }
}
