<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Input;

/**
 * Base for boolean input tags such as checkboxes and radios.
 */
abstract class BooleanInputTag extends InputTag
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
     * @param string|null $label Input label.
     * @param array $attributes Name-value set of label attributes.
     *
     * @return static
     */
    final public function label(?string $label, array $attributes = []): self
    {
        $new = clone $this;
        $new->label = $label;
        $new->labelAttributes = $attributes;
        return $new;
    }

    /**
     * Label that is rendered separately and is referring input by ID.
     *
     * @param string|null $label Input label.
     * @param array $attributes Name-value set of label attributes.
     *
     * @return static
     */
    final public function sideLabel(?string $label, array $attributes = []): self
    {
        $new = clone $this;
        $new->label = $label;
        $new->labelAttributes = $attributes;
        $new->labelWrap = false;
        return $new;
    }

    /**
     * @param bool $encode Whether to encode label content. Defaults to `true`.
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
        $this->attributes['id'] ??= ($this->labelWrap || $this->label === null)
            ? null
            : Html::generateId();

        return $this->renderUncheckInput() .
            ($this->labelWrap ? $this->renderLabelOpenTag($this->labelAttributes) : '');
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

    private function renderLabelOpenTag(array $attributes): string
    {
        if ($this->label === null) {
            return '';
        }

        return Html::openTag('label', $attributes);
    }

    final protected function after(): string
    {
        if ($this->label === null) {
            return '';
        }

        if ($this->labelWrap) {
            $html = $this->label === '' ? '' : ' ';
        } else {
            $labelAttributes = array_merge($this->labelAttributes, [
                'for' => $this->attributes['id'],
            ]);
            $html = ' ' . $this->renderLabelOpenTag($labelAttributes);
        }

        $html .= $this->labelEncode ? Html::encode($this->label) : $this->label;

        $html .= '</label>';

        return $html;
    }

    abstract protected function getType(): string;
}
