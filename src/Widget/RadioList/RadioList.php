<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\RadioList;

use Closure;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;
use Yiisoft\Html\Tag\Input;

/**
 * `RadioList` represents a list of radios and their corresponding labels.
 */
final class RadioList implements NoEncodeStringableInterface
{
    private ?string $containerTag = 'div';
    private array $containerAttributes = [];
    private array $radioAttributes = [];

    /**
     * @var array[]
     */
    private array $individualInputAttributes = [];

    private ?string $uncheckValue = null;
    private string $separator = "\n";
    private bool $encodeLabels = true;

    /**
     * @var string[]
     */
    private array $items = [];

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

    public function name(string $name): self
    {
        $new = clone $this;
        $new->name = $name;
        return $new;
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

    /**
     * @deprecated Use {@see addRadioAttributes()} or {@see replaceRadioAttributes()} instead. In the next major version
     * `replaceRadioAttributes()` method will be renamed to `radioAttributes()`.
     */
    public function radioAttributes(array $attributes): self
    {
        return $this->addRadioAttributes($attributes);
    }

    public function addRadioAttributes(array $attributes): self
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
     * @param array[] $attributes
     *
     * @deprecated Use {@see addIndividualInputAttributes()} or {@see replaceIndividualInputAttributes()} instead. In
     * the next major version `replaceIndividualInputAttributes()` method will be renamed to
     * `individualInputAttributes()`.
     */
    public function individualInputAttributes(array $attributes): self
    {
        return $this->addIndividualInputAttributes($attributes);
    }

    /**
     * @param array[] $attributes
     */
    public function addIndividualInputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->individualInputAttributes = array_replace($new->individualInputAttributes, $attributes);
        return $new;
    }

    /**
     * @param array[] $attributes
     */
    public function replaceIndividualInputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->individualInputAttributes = $attributes;
        return $new;
    }

    /**
     * @param string[] $items
     * @param bool $encodeLabels Whether labels should be encoded.
     */
    public function items(array $items, bool $encodeLabels = true): self
    {
        $new = clone $this;
        $new->items = $items;
        $new->encodeLabels = $encodeLabels;
        return $new;
    }

    /**
     * Fills items from an array provided. Array values are used for both input labels and input values.
     *
     * @param bool[]|float[]|int[]|string[]|\Stringable[] $values
     * @param bool $encodeLabels Whether labels should be encoded.
     */
    public function itemsFromValues(array $values, bool $encodeLabels = true): self
    {
        $values = array_map('\strval', $values);

        return $this->items(
            array_combine($values, $values),
            $encodeLabels
        );
    }

    /**
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function value($value): self
    {
        $new = clone $this;
        $new->value = $value === null ? null : (string) $value;
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
        $new->uncheckValue = $value === null ? null : (string) $value;
        return $new;
    }

    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->separator = $separator;
        return $new;
    }

    /**
     * @param Closure|null $formatter
     *
     * @psalm-param Closure(RadioItem):string|null $formatter
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
                array_merge(
                    $this->radioAttributes,
                    $this->individualInputAttributes[$value] ?? [],
                    ['name' => $this->name, 'value' => $value]
                ),
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
        return
            Input::hidden(
                Html::getNonArrayableName($this->name),
                $this->uncheckValue
            )
                ->addAttributes(
                    array_merge(
                        [
                            // Make sure disabled input is not sending any value
                            'disabled' => $this->radioAttributes['disabled'] ?? null,
                            'form' => $this->radioAttributes['form'] ?? null,
                        ],
                        $this->individualInputAttributes[$this->uncheckValue] ?? []
                    )
                )
                ->render();
    }

    private function formatItem(RadioItem $item): string
    {
        if ($this->itemFormatter !== null) {
            return ($this->itemFormatter)($item);
        }

        $radio = Html::radio($item->name, $item->value, $item->radioAttributes)
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
