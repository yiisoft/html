<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://www.w3.org/TR/html52/document-metadata.html#the-link-element
 */
final class Link extends VoidTag
{
    public static function toCssFile(string $url): self
    {
        $link = self::tag();
        $link->attributes['rel'] = 'stylesheet';
        $link->attributes['href'] = $url;
        return $link;
    }

    /**
     * Alias for {@see href}
     */
    public function url(?string $url): self
    {
        return $this->href($url);
    }

    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#element-attrdef-link-href
     */
    public function href(?string $url): self
    {
        $new = clone $this;
        $new->attributes['href'] = $url;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#element-attrdef-link-rel
     */
    public function rel(?string $rel): self
    {
        $new = clone $this;
        $new->attributes['rel'] = $rel;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#element-attrdef-link-type
     */
    public function type(?string $type): self
    {
        $new = clone $this;
        $new->attributes['type'] = $type;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#element-attrdef-link-title
     */
    public function title(?string $title): self
    {
        $new = clone $this;
        $new->attributes['title'] = $title;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#element-attrdef-link-crossorigin
     */
    public function crossOrigin(?string $value): self
    {
        $new = clone $this;
        $new->attributes['crossorigin'] = $value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/preload/#as-attribute
     */
    public function as(?string $value): self
    {
        $new = clone $this;
        $new->attributes['as'] = $value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/preload/#link-type-preload
     * @link https://www.w3.org/TR/preload/#as-attribute
     */
    public function preload(string $url, string $as = null): self
    {
        $new = clone $this;
        $new->attributes['rel'] = 'preload';
        $new->attributes['href'] = $url;
        if ($as !== null) {
            $new->attributes['as'] = $as;
        }
        return $new;
    }

    protected function getName(): string
    {
        return 'link';
    }
}
