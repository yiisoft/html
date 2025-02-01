<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Stringable;
use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/mo
 */
final class Mo extends NormalTag implements MathItemInterface
{
    private string|Stringable $operator;

    protected function getName(): string
    {
        return 'mo';
    }

    protected function generateContent(): string
    {
        return (string) $this->operator;
    }

    public function operator(string|Stringable $operator): self
    {
        $new = clone $this;
        $new->operator = $operator;

        return $new;
    }

    private function booleanAttribute(string $name, bool|null $value): self
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes[$name]);
        } else {
            $new->attributes[$name] = $value ? 'true' : 'false';
        }

        return $new;
    }

    private function lengthAttribute(string $name, string|null $value): self
    {
        $new = clone $this;

        if ($value === null) {
            unset($new->attributes[$name]);
        } else {
            $new->attributes[$name] = $value;
        }

        return $new;
    }

    public function form(OperatorForm|null $form): self
    {
        $new = clone $this;

        if ($form) {
            $new->attributes['form'] = $form->name;
        } else {
            unset($new->attributes['form']);
        }

        return $new;
    }

    public function fence(bool|null $fence): self
    {
        return $this->booleanAttribute('fence', $fence);
    }

    public function largeop(bool|null $largeop): self
    {
        return $this->booleanAttribute('largeop', $largeop);
    }

    public function lspace(string|null $lspace): self
    {
        return $this->lengthAttribute('lspace', $lspace);
    }

    public function maxsize(string|null $maxsize): self
    {
        return $this->lengthAttribute('maxsize', $maxsize);
    }

    public function minsize(string|null $minsize): self
    {
        return $this->lengthAttribute('minsize', $minsize);
    }

    public function movablelimits(bool|null $movablelimits): self
    {
        return $this->booleanAttribute('movablelimits', $movablelimits);
    }

    public function rspace(string|null $rspace): self
    {
        return $this->lengthAttribute('rspace', $rspace);
    }

    public function separator(bool|null $separator): self
    {
        return $this->booleanAttribute('separator', $separator);
    }

    public function stretchy(bool|null $stretchy): self
    {
        return $this->booleanAttribute('stretchy', $stretchy);
    }

    public function symmetric(bool|null $symmetric): self
    {
        return $this->booleanAttribute('symmetric', $symmetric);
    }
}
