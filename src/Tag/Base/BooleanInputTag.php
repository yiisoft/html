<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input;

abstract class BooleanInputTag extends BaseInputTag
{
    private ?string $uncheckValue = null;

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-input-checked
     *
     * @return static
     */
    final public function checked(bool $checked = true): self
    {
        $new = clone $this;
        $new->attributes['checked'] = $checked;
        return $new;
    }

    /**
     * @param \Stringable|string|int|float|bool|null $value
     *
     * @return static
     */
    final public function uncheckValue($value): self
    {
        $new = clone $this;
        $new->uncheckValue = $value === null ? null : (string)$value;
        return $new;
    }

    final protected function prepareAttributes(): void
    {
        $this->attributes['type'] = $this->getType();
    }

    protected function before(): string
    {
        $name = (string)($this->attributes['name'] ?? '');
        if (empty($name) || $this->uncheckValue === null) {
            return '';
        }

        $input = Input::hidden(
            Html::getNonArrayableName($name),
            $this->uncheckValue
        );

        // Make sure disabled input is not sending any value
        if (!empty($this->attributes['disabled'])) {
            $input = $input->attribute('disabled', $this->attributes['disabled']);
        }

        if (!empty($this->attributes['form'])) {
            $input = $input->attribute('form', $this->attributes['form']);
        }

        return $input->render();
    }

    abstract protected function getType(): string;
}
