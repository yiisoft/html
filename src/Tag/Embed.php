<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://html.spec.whatwg.org/multipage/embedded-content.html#the-embed-element
 */
final class Embed extends VoidTag
{
    public function src(?string $url): self
    {
        $new = clone $this;
        $new->attributes['src'] = $url;
        return $new;
    }

    public function type(?string $type): self
    {
        $new = clone $this;
        $new->attributes['type'] = $type;
        return $new;
    }

    public function width(int|string|null $width): self
    {
        $new = clone $this;
        $new->attributes['width'] = $width;
        return $new;
    }

    public function height(int|string|null $height): self
    {
        $new = clone $this;
        $new->attributes['height'] = $height;
        return $new;
    }

    protected function getName(): string
    {
        return 'embed';
    }
}
