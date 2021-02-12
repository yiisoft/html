<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Html;

abstract class BaseNormalTag extends Tag
{
    private bool $encode = true;
    private bool $doubleEncode = true;
    private string $content = '';

    /**
     * @return static
     */
    final public function withoutEncode(): self
    {
        $new = clone $this;
        $new->encode = false;
        return $new;
    }

    /**
     * @return static
     */
    final public function withoutDoubleEncode(): self
    {
        $new = clone $this;
        $new->doubleEncode = false;
        return $new;
    }

    /**
     * @return static
     */
    final public function content(string $content): self
    {
        $new = clone $this;
        $new->content = $content;
        return $new;
    }

    final protected function generateContent(): string
    {
        return $this->encode ? Html::encode($this->content, $this->doubleEncode) : $this->content;
    }

    final public function begin(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }

    final public function end(): string
    {
        return '</' . $this->getName() . '>';
    }
}
