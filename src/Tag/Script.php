<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use LogicException;
use Stringable;
use Yiisoft\Html\Tag\Base\NormalTag;

use function get_debug_type;
use function is_string;
use function sprintf;

/**
 * @link https://www.w3.org/TR/html52/semantics-scripting.html#the-script-element
 */
final class Script extends NormalTag
{
    private string $content = '';
    private ?Noscript $noscript = null;

    /**
     * @link https://www.w3.org/TR/html52/semantics-scripting.html#script-content-restrictions
     *
     * @param string $content Tag content.
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
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/nonce
     */
    public function nonce(?string $nonce): self
    {
        $new = clone $this;

        if ($nonce === null) {
            unset($new->attributes['nonce']);
        } else {
            $new->attributes['nonce'] = $nonce;
        }

        return $new;
    }

    public function getNonce(): ?string
    {
        $nonce = $this->attributes['nonce'] ?? null;

        if (is_string($nonce) || $nonce === null) {
            return $nonce;
        }

        throw new LogicException(
            sprintf(
                'Nonce should be string or null. Got %s.',
                get_debug_type($nonce)
            )
        );
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

    public function noscript(string|Stringable|null $content): self
    {
        $new = clone $this;
        $new->noscript = $content === null ? null : Noscript::tag()->content($content);
        return $new;
    }

    public function noscriptTag(?Noscript $noscript): self
    {
        $new = clone $this;
        $new->noscript = $noscript;
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

    protected function after(): string
    {
        return $this->noscript !== null ? (string) $this->noscript : '';
    }
}
