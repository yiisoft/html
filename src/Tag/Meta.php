<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://www.w3.org/TR/html52/document-metadata.html#the-meta-element
 */
final class Meta extends VoidTag
{
    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#standard-metadata-names
     */
    public static function data(string $name, string $content): self
    {
        $tag = self::tag();
        $tag->attributes['name'] = $name;
        $tag->attributes['content'] = $content;
        return $tag;
    }

    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#pragma-directives
     */
    public static function pragmaDirective(string $name, string $content): self
    {
        $tag = self::tag();
        $tag->attributes['http-equiv'] = $name;
        $tag->attributes['content'] = $content;
        return $tag;
    }

    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#specifying-the-documents-character-encoding
     */
    public static function documentEncoding(string $encoding): self
    {
        $tag = self::tag();
        $tag->attributes['charset'] = $encoding;
        return $tag;
    }

    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#description
     */
    public static function description(string $content): self
    {
        $tag = self::tag();
        $tag->attributes['name'] = 'description';
        $tag->attributes['content'] = $content;
        return $tag;
    }

    /**
     * Metadata name
     */
    public function name(?string $name): self
    {
        $new = clone $this;
        $new->attributes['name'] = $name;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#dom-htmlmetaelement-httpequiv
     */
    public function httpEquiv(?string $name): self
    {
        $new = clone $this;
        $new->attributes['http-equiv'] = $name;
        return $new;
    }

    /**
     * Value of the element
     */
    public function content(?string $content): self
    {
        $new = clone $this;
        $new->attributes['content'] = $content;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/document-metadata.html#element-attrdef-meta-charset
     */
    public function charset(?string $charset): self
    {
        $new = clone $this;
        $new->attributes['charset'] = $charset;
        return $new;
    }

    protected function getName(): string
    {
        return 'meta';
    }
}
