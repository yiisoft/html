<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Html;

/**
 * Base for all normal tags. Normal tags are the ones that have both opening tag and closing tag.
 */
abstract class BaseNormalTag extends Tag
{
    private bool $encode = true;
    private bool $doubleEncode = true;
    private string $content = '';

    /**
     * Do not HTML-encode tag content.
     * @return static
     */
    final public function withoutEncode(): self
    {
        $new = clone $this;
        $new->encode = false;
        return $new;
    }

    /**
     * Do not double-encode already encoded HTML entities in tag content.
     * @return static
     */
    final public function withoutDoubleEncode(): self
    {
        $new = clone $this;
        $new->doubleEncode = false;
        return $new;
    }

    /**
     * @param string $content Tag content.
     * @return static
     */
    final public function content(string $content): self
    {
        $new = clone $this;
        $new->content = $content;
        return $new;
    }

    /**
     * @return string Obtain tag content considering encoding options.
     */
    final protected function generateContent(): string
    {
        return $this->encode ? Html::encode($this->content, $this->doubleEncode) : $this->content;
    }

    /**
     * @return string Opening tag.
     */
    final public function open(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }

    /**
     * @return string Closing tag.
     */
    final public function close(): string
    {
        return '</' . $this->getName() . '>';
    }
}
