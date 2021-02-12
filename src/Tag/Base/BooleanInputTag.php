<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input;

abstract class BooleanInputTag extends BaseInputTag
{
    private ?string $uncheckValue = null;
    private ?string $label = null;
    private array $labelAttributes = [];
    private bool $labelWrap = true;
    private bool $labelEncode = true;

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
     * @return static
     */
    final public function label(string $label, array $attributes = []): self
    {
        $new = clone $this;
        $new->label = $label;
        $new->labelAttributes = $attributes;
        return $new;
    }

    /**
     * @return static
     */
    final public function sideLabel(string $label, array $attributes = []): self
    {
        $new = clone $this;
        $new->label = $label;
        $new->labelAttributes = $attributes;
        $new->labelWrap = false;
        return $new;
    }

    /**
     * @return static
     */
    final public function withoutLabelEncode(): self
    {
        $new = clone $this;
        $new->labelEncode = false;
        return $new;
    }

    /**
     * @param bool|float|int|string|\Stringable|null $value
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
        $this->attributes['id'] ??= $this->labelWrap ? null : Html::generateId();

        return ($this->labelWrap ? $this->renderBeginLabel() : '') .
            $this->renderUncheckInput();
    }

    private function renderUncheckInput(): string
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

    private function renderBeginLabel(): string
    {
        if ($this->label === null) {
            return '';
        }

        $attributes = $this->labelAttributes;
        /** @var mixed */
        $attributes['for'] = $this->attributes['id'];

        return Html::beginTag('label', $attributes);
    }

    protected function after(): string
    {
        if ($this->label === null) {
            return '';
        }

        return ' ' .
            ($this->labelWrap ? '' : $this->renderBeginLabel()) .
            ($this->labelEncode ? Html::encode($this->label) : $this->label) .
            '</label>';
    }

    abstract protected function getType(): string;
}
