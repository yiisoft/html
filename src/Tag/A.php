<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://www.w3.org/TR/html52/textlevel-semantics.html#the-a-element
 */
final class A extends NormalTag
{
    /**
     * @link https://www.w3.org/TR/html52/links.html#element-attrdef-a-href
     */
    public function href(?string $href): self
    {
        $new = clone $this;
        $new->attributes['href'] = $href;
        return $new;
    }

    /**
     * Alias for {@see href}
     */
    public function url(?string $url): self
    {
        return $this->href($url);
    }

    public function mailto(?string $mail): self
    {
        return $this->href($mail === null ? null : 'mailto:' . $mail);
    }

    /**
     * Default browsing context for hyperlink navigation
     *
     * @link https://www.w3.org/TR/html52/browsers.html#valid-browsing-context-names-or-keywords
     */
    public function target(?string $contextName): self
    {
        $new = clone $this;
        $new->attributes['target'] = $contextName;
        return $new;
    }

    protected function getName(): string
    {
        return 'a';
    }
}
