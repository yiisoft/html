<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#the-meter-element
 */
final class Meter extends NormalTag
{
    use TagContentTrait;

    public function min(float|int|null $value): self
    {
        $new = clone $this;
        $new->attributes['min'] = $value;
        return $new;
    }

    public function max(float|int|null $value): self
    {
        $new = clone $this;
        $new->attributes['max'] = $value;
        return $new;
    }

    public function value(float|int|null $value): self
    {
        $new = clone $this;
        $new->attributes['value'] = $value;
        return $new;
    }

    public function low(float|int|null $value): self
    {
        $new = clone $this;
        $new->attributes['low'] = $value;
        return $new;
    }

    public function high(float|int|null $value): self
    {
        $new = clone $this;
        $new->attributes['high'] = $value;
        return $new;
    }

    public function optimum(float|int|null $value): self
    {
        $new = clone $this;
        $new->attributes['optimum'] = $value;
        return $new;
    }

    protected function getName(): string
    {
        return 'meter';
    }
}
