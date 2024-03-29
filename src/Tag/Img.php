<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://www.w3.org/TR/html52/semantics-embedded-content.html#the-img-element
 */
final class Img extends VoidTag
{
    public function url(?string $url): self
    {
        return $this->src($url);
    }

    public function src(?string $url): self
    {
        $new = clone $this;
        $new->attributes['src'] = $url;
        return $new;
    }

    public function srcset(?string ...$items): self
    {
        $items = array_filter($items, static fn ($item) => $item !== null);

        $new = clone $this;
        $new->attributes['srcset'] = $items ? implode(',', $items) : null;
        return $new;
    }

    /**
     * @param array<string, string> $data
     */
    public function srcsetData(array $data): self
    {
        $new = clone $this;

        $items = [];
        foreach ($data as $descriptor => $url) {
            $items[] = $url . ' ' . $descriptor;
        }
        $new->attributes['srcset'] = $items ? implode(',', $items) : null;

        return $new;
    }

    public function alt(?string $text): self
    {
        $new = clone $this;
        $new->attributes['alt'] = $text;
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

    public function size(int|string|null $width, int|string|null $height): self
    {
        $new = clone $this;
        $new->attributes['width'] = $width;
        $new->attributes['height'] = $height;
        return $new;
    }

    public function loading(?string $loading): self
    {
        $new = clone $this;
        $new->attributes['loading'] = $loading;
        return $new;
    }

    protected function getName(): string
    {
        return 'img';
    }
}
