<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://www.w3.org/TR/html52/semantics-scripting.html#the-script-element
 */
final class Script extends NormalTag
{
    private string $content = '';

    /**
     * @link https://www.w3.org/TR/html52/semantics-scripting.html#script-content-restrictions
     *
     * @param string $content Tag content.
     *
     * @return static
     */
    public function content(string $content): self
    {
        $new = clone $this;
        $new->content = $content;
        return $new;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Alias for {@see src}
     */
    public function url(?string $url): self
    {
        return $this->src($url);
    }

    /**
     * @link https://www.w3.org/TR/html52/semantics-scripting.html#element-attrdef-script-src
     */
    public function src(?string $url): self
    {
        $new = clone $this;
        $new->attributes['src'] = $url;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/semantics-scripting.html#element-attrdef-script-type
     */
    public function type(?string $type): self
    {
        $new = clone $this;
        $new->attributes['type'] = $type;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/semantics-scripting.html#element-attrdef-script-charset
     */
    public function charset(?string $charset): self
    {
        $new = clone $this;
        $new->attributes['charset'] = $charset;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/semantics-scripting.html#element-attrdef-script-async
     */
    public function async(bool $async = true): self
    {
        $new = clone $this;
        $new->attributes['async'] = $async;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/semantics-scripting.html#element-attrdef-script-defer
     */
    public function defer(bool $defer = true): self
    {
        $new = clone $this;
        $new->attributes['defer'] = $defer;
        return $new;
    }

    protected function getName(): string
    {
        return 'script';
    }

    /**
     * @return string Obtain tag content.
     */
    protected function generateContent(): string
    {
        return $this->content;
    }
}
