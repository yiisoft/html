<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Html;

/**
 * Base for all normal tags. Normal tags are the ones that have both opening tag and closing tag.
 */
abstract class ContentTag extends Tag
{
    private bool $encode = true;
    private bool $encodeSpaces = false;
    private bool $doubleEncode = true;
    private string $content = '';

    /**
     * @param bool $encode Whether to encode tag content. Defaults to `true`.
     *
     * @return static
     */
    final public function encode(bool $encode): self
    {
        $new = clone $this;
        $new->encode = $encode;
        return $new;
    }

    /**
     * @param bool $encodeSpaces Whether to encode spaces in tag content with `&nbsp;` character. Defaults to `false`.
     *
     * @return static
     */
    final public function encodeSpaces(bool $encodeSpaces): self
    {
        $new = clone $this;
        $new->encodeSpaces = $encodeSpaces;
        return $new;
    }

    /**
     * @param bool $doubleEncode Whether already encoded HTML entities in tag content should be encoded.
     * Defaults to `true`.
     *
     * @return static
     */
    final public function doubleEncode(bool $doubleEncode): self
    {
        $new = clone $this;
        $new->doubleEncode = $doubleEncode;
        return $new;
    }

    /**
     * @param string $content Tag content.
     *
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
        $content = $this->content;
        if ($this->encode) {
            $content = Html::encode($this->content, $this->doubleEncode);
        }
        if ($this->encodeSpaces) {
            $content = str_replace(' ', '&nbsp;', $content);
        }
        return $content;
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
