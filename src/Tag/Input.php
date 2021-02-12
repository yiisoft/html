<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-input-element
 */
final class Input extends VoidTag
{
    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#hidden-state-typehidden
     *
     * @param \Stringable|string|int|float|bool|null $value
     */
    public static function hidden(?string $name = null, $value = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'hidden';
        $input->attributes['name'] = $name;
        $input->attributes['value'] = $value;
        return $input;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#text-typetext-state-and-search-state-typesearch
     *
     * @param \Stringable|string|int|float|bool|null $value
     */
    public static function text(?string $name = null, $value = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'text';
        $input->attributes['name'] = $name;
        $input->attributes['value'] = $value;
        return $input;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#password-state-typepassword
     *
     * @param \Stringable|string|int|float|bool|null $value
     */
    public static function password(?string $name = null, $value = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'password';
        $input->attributes['name'] = $name;
        $input->attributes['value'] = $value;
        return $input;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#file-upload-state-typefile
     *
     * @param \Stringable|string|int|float|bool|null $value
     */
    public static function file(?string $name = null, $value = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'file';
        $input->attributes['name'] = $name;
        $input->attributes['value'] = $value;
        return $input;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#checkbox-state-typecheckbox
     *
     * @param \Stringable|string|int|float|bool|null $value
     */
    public static function checkbox(?string $name = null, $value = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'checkbox';
        $input->attributes['name'] = $name;
        $input->attributes['value'] = $value;
        return $input;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#radio-button-state-typeradio
     *
     * @param \Stringable|string|int|float|bool|null $value
     */
    public static function radio(?string $name = null, $value = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'radio';
        $input->attributes['name'] = $name;
        $input->attributes['value'] = $value;
        return $input;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#button-state-typebutton
     */
    public static function button(?string $label = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'button';
        $input->attributes['value'] = $label;
        return $input;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#submit-button-state-typesubmit
     */
    public static function submitButton(?string $label = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'submit';
        $input->attributes['value'] = $label;
        return $input;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#reset-button-state-typereset
     */
    public static function resetButton(?string $label = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'reset';
        $input->attributes['value'] = $label;
        return $input;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-input-type
     */
    public function type(?string $type): self
    {
        $new = clone $this;
        $new->attributes['type'] = $type;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-name
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
     * @param \Stringable|string|int|float|bool|null $value
     */
    public function value($value): self
    {
        $new = clone $this;
        $new->attributes['value'] = $value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-form
     */
    public function form(?string $formId): self
    {
        $new = clone $this;
        $new->attributes['form'] = $formId;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-readonly-attribute
     */
    public function readonly(bool $readonly = true): self
    {
        $new = clone $this;
        $new->attributes['readonly'] = $readonly;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-required-attribute
     */
    public function required(bool $required = true): self
    {
        $new = clone $this;
        $new->attributes['required'] = $required;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-input-checked
     */
    public function checked(bool $checked = true): self
    {
        $new = clone $this;
        $new->attributes['checked'] = $checked;
        return $new;
    }

    protected function getName(): string
    {
        return 'input';
    }
}
