<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Input;

use Yiisoft\Html\Tag\Base\InputTag;

/**
 * An imprecise control for setting the element’s value to a string representing a number.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#range-state-(type=range)
 */
final class Range extends InputTag
{
    /**
     * Maximum value.
     *
     * @param float|int|string|\Stringable|null $value
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-max
     */
    public function max($value): self
    {
        $new = clone $this;
        $new->attributes['max'] = $value;
        return $new;
    }

    /**
     * Minimum value.
     *
     * @param float|int|string|\Stringable|null $value
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-min
     */
    public function min($value): self
    {
        $new = clone $this;
        $new->attributes['min'] = $value;
        return $new;
    }

    /**
     * Granularity to be matched by the form control's value.
     *
     * @param float|int|string|\Stringable|null $value
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-step
     */
    public function step($value): self
    {
        $new = clone $this;
        $new->attributes['step'] = $value;
        return $new;
    }

    /**
     * ID of element that lists predefined options suggested to the user.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#the-list-attribute
     */
    public function list(?string $id): self
    {
        $new = clone $this;
        $new->attributes['list'] = $id;
        return $new;
    }

    protected function prepareAttributes(): void
    {
        $this->attributes['type'] = 'range';
    }
}
