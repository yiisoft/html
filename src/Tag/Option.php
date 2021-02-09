<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-option-element
 */
final class Option extends NormalTag
{
    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-option-value
     */
    public function value(?string $value): self
    {
        $new = clone $this;
        $new->attributes['value'] = $value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-option-selected
     */
    public function selected(bool $selected = true): self
    {
        $new = clone $this;
        $new->attributes['selected'] = $selected;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-option-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

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
