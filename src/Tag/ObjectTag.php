<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/embedded-content.html#the-object-element
 */
final class ObjectTag extends NormalTag
{
    use TagContentTrait;

    public function data(?string $url): self
    {
        $new = clone $this;
        $new->attributes['data'] = $url;
        return $new;
    }

    public function form(?string $id): self
    {
        $new = clone $this;
        $new->attributes['form'] = $id;
        return $new;
    }

    public function name(?string $name): self
    {
        $new = clone $this;
        $new->attributes['name'] = $name;
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
        return 'object';
    }
}
