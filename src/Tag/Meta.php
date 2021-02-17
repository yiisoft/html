<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://www.w3.org/TR/html52/document-metadata.html#the-meta-element
 */
final class Meta extends VoidTag
{
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
     * Value of the element
     */
    public function content(?string $content): self
    {
        $new = clone $this;
        $new->attributes['content'] = $content;
        return $new;
    }

    protected function getName(): string
    {
        return 'meta';
    }
}
