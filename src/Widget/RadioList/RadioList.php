<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\RadioList;

use Closure;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;
use Yiisoft\Html\Tag\Input;

/**
 * RadioList represents a list of radios and their corresponding labels.
 */
final class RadioList implements NoEncodeStringableInterface
{
    private ?string $containerTag = 'div';
    private array $containerAttributes = [];
    private array $radioAttributes = [];
    private ?string $uncheckValue = null;
    private string $separator = "\n";
    private bool $encodeLabels = true;

    /**
     * @var string[]
     */
    private array $items = [];

    /**
     * @psalm-param non-empty-string
     */
    private string $name;

    private ?string $value = null;

    /**
     * @psalm-var Closure(RadioItem):string|null
     */
    private ?Closure $itemFormatter = null;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name): self
    {
        return new self($name);
    }

    public function withoutContainer(): self
    {
        $new = clone $this;
        $new->containerTag = null;
        return $new;
    }

    public function containerTag(?string $name): self
    {
        $new = clone $this;
        $new->containerTag = $name;
        return $new;
    }

    public function containerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->containerAttributes = $attributes;
        return $new;
    }

    public function radioAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->radioAttributes = array_merge($new->radioAttributes, $attributes);
        return $new;
    }

    public function replaceRadioAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->radioAttributes = $attributes;
        return $new;
    }

    /**
     * @param string[] $items
     */
    public function items(array $items, bool $encodeLabels = true): self
    {
        $new = clone $this;
        $new->items = $items;
        $new->encodeLabels = $encodeLabels;
        return $new;
    }

    /**
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function value($value): self
    {
        $new = clone $this;
        $new->value = $value === null ? null : (string)$value;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-form
     */
    public function form(?string $formId): self
    {
        $new = clone $this;
        $new->radioAttributes['form'] = $formId;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-readonly-attribute
     */
    public function readonly(bool $readonly = true): self
    {
        $new = clone $this;
        $new->radioAttributes['readonly'] = $readonly;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->radioAttributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function uncheckValue($value): self
    {
        $new = clone $this;
        $new->uncheckValue = $value === null ? null : (string)$value;
        return $new;
    }

    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->separator = $separator;
        return $new;
    }

    /**
     * @param Closure(RadioItem):string|null $formatter
     */
    public function itemFormatter(?Closure $formatter): self
    {
        $new = clone $this;
        $new->itemFormatter = $formatter;
        return $new;
    }

    public function render(): string
    {
        $lines = [];
        $index = 0;
        foreach ($this->items as $value => $label) {
            $item = new RadioItem(
                $index,
                $this->name,
                $value,
                $this->value !== null && $this->value == $value,
                array_merge($this->radioAttributes, [
                    'name' => $this->name,
                    'value' => $value,
                ]),
                $label,
                $this->encodeLabels,
            );
            $lines[] = $this->formatItem($item);
            $index++;
        }

        $html = [];
        if ($this->uncheckValue !== null) {
            $html[] = $this->renderUncheckInput();
        }
        if (!empty($this->containerTag)) {
            $html[] = Html::openTag($this->containerTag, $this->containerAttributes);
        }
        if ($lines) {
            $html[] = implode($this->separator, $lines);
        }
        if (!empty($this->containerTag)) {
            $html[] = Html::closeTag($this->containerTag);
        }

        return implode("\n", $html);
    }

    private function renderUncheckInput(): string
    {
        $input = Input::hidden(
            Html::getNonArrayableName($this->name),
            $this->uncheckValue
        );

        // Make sure disabled input is not sending any value
        if (!empty($this->radioAttributes['disabled'])) {
            $input = $input->attribute('disabled', $this->radioAttributes['disabled']);
        }

        if (!empty($this->radioAttributes['form'])) {
            $input = $input->attribute('form', $this->radioAttributes['form']);
        }

        return $input->render();
    }

    private function formatItem(RadioItem $item): string
    {
        if ($this->itemFormatter !== null) {
            return ($this->itemFormatter)($item);
        }

        $radio = Html::radio($item->name, $item->value)
            ->attributes($item->radioAttributes)
            ->checked($item->checked)
            ->label($item->label)
            ->labelEncode($item->encodeLabel);

        return $radio->render();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
