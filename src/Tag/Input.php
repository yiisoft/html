<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\InputTag;
use Yiisoft\Html\Tag\Input\Checkbox;
use Yiisoft\Html\Tag\Input\File;
use Yiisoft\Html\Tag\Input\Radio;
use Yiisoft\Html\Tag\Input\Range;

/**
 * HTML input.
 *
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-input-element
 */
final class Input extends InputTag
{
    /**
     * Hidden input.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#hidden-state-typehidden
     *
     * @param string|null $name Name of the input.
     * @param bool|float|int|string|\Stringable|null $value Value of the input.
     *
     * @return self
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
     * Text input.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#text-typetext-state-and-search-state-typesearch
     *
     * @param string|null $name Name of the input.
     * @param bool|float|int|string|\Stringable|null $value Value of the input.
     *
     * @return self
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
     * Password input.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#password-state-typepassword
     *
     * @param string|null $name Name of the input.
     * @param bool|float|int|string|\Stringable|null $value Value of the input.
     *
     * @return self
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
     * File input.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#file-upload-state-typefile
     *
     * @param string|null $name Name of the input.
     * @param bool|float|int|string|\Stringable|null $value Value of the input.
     *
     * @return self
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
     * File input.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#file-upload-state-typefile
     *
     * @param string|null $name Name of the input.
     * @param bool|float|int|string|\Stringable|null $value Value of the input.
     *
     * @return File
     *
     * @deprecated
     */
    public static function fileControl(?string $name = null, $value = null): File
    {
        $input = File::tag();
        if ($name !== null) {
            $input = $input->name($name);
        }
        if ($value !== null) {
            $input = $input->value($value);
        }
        return $input;
    }

    /**
     * Checkbox input.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#checkbox-state-typecheckbox
     *
     * @param string|null $name Name of the input.
     * @param bool|float|int|string|\Stringable|null $value Value of the input.
     *
     * @return Checkbox
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
     * Radio input.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#radio-button-state-typeradio
     *
     * @param string|null $name Name of the input.
     * @param bool|float|int|string|\Stringable|null $value Value of the input.
     *
     * @return Radio
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
     * Range.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#range-state-(type=range)
     *
     * @param string|null $name Name of the input.
     * @param float|int|string|\Stringable|null $value Value of the input.
     */
    public static function range(?string $name = null, $value = null): Range
    {
        $input = Range::tag();
        if ($name !== null) {
            $input = $input->name($name);
        }
        if ($value !== null) {
            $input = $input->value($value);
        }
        return $input;
    }

    /**
     * Button.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#button-state-typebutton
     *
     * @param string|null $label Button label.
     *
     * @return self
     */
    public static function button(?string $label = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'button';
        $input->attributes['value'] = $label;
        return $input;
    }

    /**
     * Submit button.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#submit-button-state-typesubmit
     *
     * @param string|null $label Button label.
     *
     * @return self
     */
    public static function submitButton(?string $label = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'submit';
        $input->attributes['value'] = $label;
        return $input;
    }

    /**
     * Reset button.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#reset-button-state-typereset
     *
     * @param string|null $label Button label.
     *
     * @return self
     */
    public static function resetButton(?string $label = null): self
    {
        $input = self::tag();
        $input->attributes['type'] = 'reset';
        $input->attributes['value'] = $label;
        return $input;
    }

    /**
     * Input with the type specified.
     *
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-input-type
     *
     * @param string|null $type Type of the input.
     *
     * @return self
     */
    public function type(?string $type): self
    {
        $new = clone $this;
        $new->attributes['type'] = $type;
        return $new;
    }
}
