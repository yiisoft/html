<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use InvalidArgumentException;

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

    /**
     * @param array<string, string>|string|null $set
     */
    public function srcset($set): self
    {
        $new = clone $this;

        if (is_array($set)) {
            $items = [];
            foreach ($set as $descriptor => $url) {
                $items[] = $url . ' ' . $descriptor;
            }
            $new->attributes['srcset'] = $items ? implode(',', $items) : null;
        } elseif (is_string($set) || is_null($set)) {
            $new->attributes['srcset'] = $set;
        } else {
            throw new InvalidArgumentException('Incorrect the srcset attribute.');
        }

        return $new;
    }

    public function alt(?string $text): self
    {
        $new = clone $this;
        $new->attributes['alt'] = $text;
        return $new;
    }

    /**
     * @param string|int|null $width
     */
    public function width($width): self
    {
        $new = clone $this;
        $new->attributes['width'] = $width;
        return $new;
    }

    /**
     * @param string|int|null $height
     */
    public function height($height): self
    {
        $new = clone $this;
        $new->attributes['height'] = $height;
        return $new;
    }

    /**
     * @param string|int|null $width
     * @param string|int|null $height
     */
    public function size($width, $height): self
    {
        $new = clone $this;
        $new->attributes['width'] = $width;
        $new->attributes['height'] = $height;
        return $new;
    }

    protected function getName(): string
    {
        return 'img';
    }
}
