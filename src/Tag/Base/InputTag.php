<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

/**
 * Base for all input tags.
 */
abstract class InputTag extends VoidTag
{
    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-name
     *
     * @param string|null $name Name of the input.
     *
     * @return static
     */
    public function name(?string $name): self
    {
        $new = clone $this;
        $new->attributes['name'] = $name;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-input-value
     *
     * @param bool|float|int|string|\Stringable|null $value Value of the input.
     *
     * @return static
     */
    public function value($value): self
    {
        $new = clone $this;
        $new->attributes['value'] = $value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-form
     *
     * @param string|null $formId ID of the form input belongs to.
     *
     * @return static
     */
    public function form(?string $formId): self
    {
        $new = clone $this;
        $new->attributes['form'] = $formId;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-readonly-attribute
     *
     * @param bool $readOnly Whether input is read only.
     *
     * @return static
     */
    public function readonly(bool $readOnly = true): self
    {
        $new = clone $this;
        $new->attributes['readonly'] = $readOnly;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-required-attribute
     *
     * @param bool $required Whether input is required.
     *
     * @return static
     */
    public function required(bool $required = true): self
    {
        $new = clone $this;
        $new->attributes['required'] = $required;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     *
     * @param bool $disabled Whether input is disabled.
     *
     * @return static
     */
    public function disabled(bool $disabled = true): self
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
