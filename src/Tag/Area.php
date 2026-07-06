<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://html.spec.whatwg.org/multipage/image-maps.html#the-area-element
 */
final class Area extends VoidTag
{
    public function alt(?string $text): self
    {
        $new = clone $this;
        $new->attributes['alt'] = $text;
        return $new;
    }

    public function coords(?string $coords): self
    {
        $new = clone $this;
        $new->attributes['coords'] = $coords;
        return $new;
    }

    public function download(?string $value): self
    {
        $new = clone $this;
        $new->attributes['download'] = $value;
        return $new;
    }

    public function href(?string $url): self
    {
        $new = clone $this;
        $new->attributes['href'] = $url;
        return $new;
    }

    public function hreflang(?string $lang): self
    {
        $new = clone $this;
        $new->attributes['hreflang'] = $lang;
        return $new;
    }

    public function referrerpolicy(?string $policy): self
    {
        $new = clone $this;
        $new->attributes['referrerpolicy'] = $policy;
        return $new;
    }

    public function rel(?string $rel): self
    {
        $new = clone $this;
        $new->attributes['rel'] = $rel;
        return $new;
    }

    public function shape(?string $shape): self
    {
        $new = clone $this;
        $new->attributes['shape'] = $shape;
        return $new;
    }

    public function target(?string $target): self
    {
        $new = clone $this;
        $new->attributes['target'] = $target;
        return $new;
    }

    public function type(?string $type): self
    {
        $new = clone $this;
        $new->attributes['type'] = $type;
        return $new;
    }

    protected function getName(): string
    {
        return 'area';
    }
}
