<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input;

/**
 * Base for boolean input tags such as checkboxes and radios.
 */
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
     * @param bool $checked Whether input it checked.
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
     * Label that is wraps around attribute when rendered.
     *
     * @param string $label Input label.
     * @param array $attributes Name-value set of label attributes.
     *
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
     * Label that is rendered separately and is referring input by ID.
     *
     * @param string $label Input label.
     * @param array $attributes Name-value set of label attributes.
     *
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
     * @patam bool $encode Whether to encode label content. Defaults to `true`.
     *
     * @return static
     */
    final public function labelEncode(bool $encode): self
    {
        $new = clone $this;
        $new->labelEncode = $encode;
        return $new;
    }

    /**
     * @param bool|float|int|string|\Stringable|null $value Value that corresponds to "unchecked" state of the input.
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

    final protected function before(): string
    {
        $this->attributes['id'] ??= $this->labelWrap ? null : Html::generateId();

        return ($this->labelWrap ? $this->renderLabelOpenTag() : '') .
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

        // Make sure disabled input is not sending any value.
        if (!empty($this->attributes['disabled'])) {
            $input = $input->attribute('disabled', $this->attributes['disabled']);
        }

        if (!empty($this->attributes['form'])) {
            $input = $input->attribute('form', $this->attributes['form']);
        }

        return $input->render();
    }

    private function renderLabelOpenTag(): string
    {
        if ($this->label === null) {
            return '';
        }

        $attributes = $this->labelAttributes;
        /** @var mixed */
        $attributes['for'] = $this->attributes['id'];

        return Html::openTag('label', $attributes);
    }

    final protected function after(): string
    {
        if ($this->label === null) {
            return '';
        }

        return ' ' .
            ($this->labelWrap ? '' : $this->renderLabelOpenTag()) .
            ($this->labelEncode ? Html::encode($this->label) : $this->label) .
            '</label>';
    }

    abstract protected function getType(): string;
}
