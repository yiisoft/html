<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\RadioList;

use BackedEnum;
use Closure;
use Stringable;
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

    private ?string $radioWrapTag = null;
    private array $radioWrapAttributes = [];

    private array $radioAttributes = [];
    private array $radioLabelAttributes = [];
    private bool $radioLabelWrap = true;

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

    private ?string $value = null;

    /**
     * @psalm-var Closure(RadioItem):string|null
     */
    private ?Closure $itemFormatter = null;

    private function __construct(
        private string $name
    ) {
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

    public function radioWrapTag(?string $name): self
    {
        $new = clone $this;
        $new->radioWrapTag = $name;
        return $new;
    }

    public function radioWrapAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->radioWrapAttributes = $attributes;
        return $new;
    }

    public function radioWrapClass(?string ...$class): self
    {
        $new = clone $this;
        $new->radioWrapAttributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        return $new;
    }

    public function addRadioWrapClass(?string ...$class): self
    {
        $new = clone $this;
        Html::addCssClass(
            $new->radioWrapAttributes,
            array_filter($class, static fn ($c) => $c !== null),
        );
        return $new;
    }

    public function addRadioAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->radioAttributes = array_merge($new->radioAttributes, $attributes);
        return $new;
    }

    public function radioAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->radioAttributes = $attributes;
        return $new;
    }

    public function addRadioLabelAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->radioLabelAttributes = array_merge($new->radioLabelAttributes, $attributes);
        return $new;
    }

    public function radioLabelAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->radioLabelAttributes = $attributes;
        return $new;
    }

    public function radioLabelWrap(bool $wrap): self
    {
        $new = clone $this;
        $new->radioLabelWrap = $wrap;
        return $new;
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
    public function individualInputAttributes(array $attributes): self
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
     * @param bool[]|float[]|int[]|string[]|Stringable[] $values
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

    public function value(bool|float|int|string|Stringable|BackedEnum|null $value): self
    {
        $new = clone $this;
        $new->value = $value === null
            ? null
            : (string) ($value instanceof BackedEnum ? $value->value : $value);
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

    public function uncheckValue(bool|float|int|string|Stringable|null $value): self
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
        if ($this->radioWrapTag === null) {
            $beforeRadio = '';
            $afterRadio = '';
        } else {
            $beforeRadio = Html::openTag($this->radioWrapTag, $this->radioWrapAttributes) . "\n";
            $afterRadio = "\n" . Html::closeTag($this->radioWrapTag);
        }

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
                $this->radioLabelAttributes,
                $this->radioLabelWrap,
            );
            $lines[] = $beforeRadio . $this->formatItem($item) . $afterRadio;
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
            ->label($item->label, $item->labelAttributes, $item->labelWrap)
            ->labelEncode($item->encodeLabel);

        return $radio->render();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
