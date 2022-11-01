<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;

/**
 * Base for all input tags.
 */
abstract class InputTag extends VoidTag
{
    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-name
     *
     * @param string|null $name Name of the input.
     */
    public function name(?string $name): static
    {
        $new = clone $this;
        $new->attributes['name'] = $name;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-input-value
     *
     * @param bool|float|int|string|Stringable|null $value Value of the input.
     */
    public function value(bool|float|int|string|Stringable|null $value): static
    {
        $new = clone $this;
        $new->attributes['value'] = $value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-form
     *
     * @param string|null $formId ID of the form input belongs to.
     */
    public function form(?string $formId): static
    {
        $new = clone $this;
        $new->attributes['form'] = $formId;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-readonly-attribute
     *
     * @param bool $readOnly Whether input is read only.
     */
    public function readonly(bool $readOnly = true): static
    {
        $new = clone $this;
        $new->attributes['readonly'] = $readOnly;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-required-attribute
     *
     * @param bool $required Whether input is required.
     */
    public function required(bool $required = true): static
    {
        $new = clone $this;
        $new->attributes['required'] = $required;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     *
     * @param bool $disabled Whether input is disabled.
     */
    public function disabled(bool $disabled = true): static
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

    protected function getName(): string
    {
        return 'input';
    }
}
