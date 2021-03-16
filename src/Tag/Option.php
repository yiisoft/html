<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-option-element
 */
final class Option extends NormalTag
{
    use TagContentTrait;

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-option-value
     *
     * @param bool|float|int|string|\Stringable|null $value Value of the option.
     */
    public function value($value): self
    {
        $new = clone $this;
        $new->attributes['value'] = $value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-option-selected
     *
     * @param bool $selected Whether option is selected.
     */
    public function selected(bool $selected = true): self
    {
        $new = clone $this;
        $new->attributes['selected'] = $selected;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-option-disabled
     *
     * @param bool $disabled Whether option is disabled.
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * @return string|null Get option value.
     */
    public function getValue(): ?string
    {
        /** @var mixed $value */
        $value = ArrayHelper::getValue($this->attributes, 'value');
        return $value === null ? null : (string)$value;
    }

    protected function getName(): string
    {
        return 'option';
    }
}
