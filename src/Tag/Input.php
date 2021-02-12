<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\BaseInputTag;
use Yiisoft\Html\Tag\Input\Checkbox;
use Yiisoft\Html\Tag\Input\Radio;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-input-element
 */
final class Input extends BaseInputTag
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
    public static function checkbox(?string $name = null, $value = null): Checkbox
    {
        $input = Checkbox::tag();
        if ($name !== null) {
            $input = $input->name($name);
        }
        if ($value !== null) {
            $input = $input->value($value);
        }
        return $input;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#radio-button-state-typeradio
     *
     * @param \Stringable|string|int|float|bool|null $value
     */
    public static function radio(?string $name = null, $value = null): Radio
    {
        $input = Radio::tag();
        if ($name !== null) {
            $input = $input->name($name);
        }
        if ($value !== null) {
            $input = $input->value($value);
        }
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
}
