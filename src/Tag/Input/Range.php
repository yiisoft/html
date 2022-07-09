<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Input;

use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\InputTag;
use Yiisoft\Html\Tag\CustomTag;

/**
 * An imprecise control for setting the element’s value to a string representing a number.
 *
 * @link https://html.spec.whatwg.org/multipage/input.html#range-state-(type=range)
 */
final class Range extends InputTag
{
    private bool $showOutput = false;

    /**
     * @psalm-var non-empty-string
     */
    private string $outputTag = 'span';
    private array $outputAttributes = [];
    private ?string $outputId = null;

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

    public function showOutput(bool $show = true): self
    {
        $new = clone $this;
        $new->showOutput = $show;
        return $new;
    }

    public function outputTag(string $tagName): self
    {
        if ($tagName === '') {
            throw new InvalidArgumentException('The output tag name it cannot be empty value.');
        }

        $new = clone $this;
        $new->outputTag = $tagName;
        return $new;
    }

    /**
     * @deprecated Use {@see addOutputAttributes()} or {@see replaceOutputAttributes()} instead. In the next major
     * version `replaceOutputAttributes()` method will be renamed to `outputAttributes()`.
     */
    public function outputAttributes(array $attributes): self
    {
        return $this->addOutputAttributes($attributes);
    }

    public function addOutputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->outputAttributes = array_merge($this->outputAttributes, $attributes);
        return $new;
    }

    public function replaceOutputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->outputAttributes = $attributes;
        return $new;
    }

    protected function prepareAttributes(): void
    {
        $this->attributes['type'] = 'range';

        if ($this->showOutput) {
            $this->outputId = (string) ($this->outputAttributes['id'] ?? Html::generateId('rangeOutput'));
            $this->attributes['oninput'] = 'document.getElementById("' . $this->outputId . '").innerHTML=this.value';
        }
    }

    protected function after(): string
    {
        if (!$this->showOutput) {
            return '';
        }

        return "\n" . CustomTag::name($this->outputTag)
                ->replaceAttributes($this->outputAttributes)
                ->content((string) ($this->attributes['value'] ?? '-'))
                ->id($this->outputId)
                ->render();
    }
}
