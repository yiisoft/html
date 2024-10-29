<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\CheckboxList;

use BackedEnum;
use Closure;
use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;
use Yiisoft\Html\Tag\Input;

use function is_array;

/**
 * `CheckboxList` represents a list of checkboxes and their corresponding labels.
 */
final class CheckboxList implements NoEncodeStringableInterface
{
    private ?string $containerTag = 'div';
    private array $containerAttributes = [];

    private ?string $checkboxWrapTag = null;
    private array $checkboxWrapAttributes = [];

    private array $checkboxAttributes = [];
    private array $checkboxLabelAttributes = [];
    private bool $checkboxLabelWrap = true;

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

    /**
     * @psalm-var list<string>
     */
    private array $values = [];

    /**
     * @psalm-var Closure(CheckboxItem):string|null
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

    public function checkboxWrapTag(?string $name): self
    {
        $new = clone $this;
        $new->checkboxWrapTag = $name;
        return $new;
    }

    public function checkboxWrapAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->checkboxWrapAttributes = $attributes;
        return $new;
    }

    public function checkboxWrapClass(?string ...$class): self
    {
        $new = clone $this;
        $new->checkboxWrapAttributes['class'] = array_filter($class, static fn ($c) => $c !== null);
        return $new;
    }

    public function addCheckboxWrapClass(?string ...$class): self
    {
        $new = clone $this;
        Html::addCssClass(
            $new->checkboxWrapAttributes,
            array_filter($class, static fn ($c) => $c !== null),
        );
        return $new;
    }

    public function addCheckboxAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->checkboxAttributes = array_merge($new->checkboxAttributes, $attributes);
        return $new;
    }

    public function checkboxAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->checkboxAttributes = $attributes;
        return $new;
    }

    public function addCheckboxLabelAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->checkboxLabelAttributes = array_merge($new->checkboxLabelAttributes, $attributes);
        return $new;
    }

    public function checkboxLabelAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->checkboxLabelAttributes = $attributes;
        return $new;
    }

    public function checkboxLabelWrap(bool $wrap): self
    {
        $new = clone $this;
        $new->checkboxLabelWrap = $wrap;
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

    public function value(bool|string|int|float|Stringable|BackedEnum ...$value): self
    {
        $new = clone $this;
        $new->values = array_map(
            static fn ($v): string => (string) ($v instanceof BackedEnum ? $v->value : $v),
            array_values($value)
        );
        return $new;
    }

    /**
     * @psalm-param iterable<int, Stringable|scalar|BackedEnum> $values
     */
    public function values(iterable $values): self
    {
        $values = is_array($values) ? $values : iterator_to_array($values);
        return $this->value(...$values);
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-form
     */
    public function form(?string $formId): self
    {
        $new = clone $this;
        $new->checkboxAttributes['form'] = $formId;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#the-readonly-attribute
     */
    public function readonly(bool $readonly = true): self
    {
        $new = clone $this;
        $new->checkboxAttributes['readonly'] = $readonly;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->checkboxAttributes['disabled'] = $disabled;
        return $new;
    }

    public function uncheckValue(bool|float|int|string|Stringable|null $value): self
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
     * @psalm-param Closure(CheckboxItem):string|null $formatter
     */
    public function itemFormatter(?Closure $formatter): self
    {
        $new = clone $this;
        $new->itemFormatter = $formatter;
        return $new;
    }

    public function render(): string
    {
        $name = Html::getArrayableName($this->name);

        if ($this->checkboxWrapTag === null) {
            $beforeCheckbox = '';
            $afterCheckbox = '';
        } else {
            $beforeCheckbox = Html::openTag($this->checkboxWrapTag, $this->checkboxWrapAttributes) . "\n";
            $afterCheckbox = "\n" . Html::closeTag($this->checkboxWrapTag);
        }

        $lines = [];
        $index = 0;
        foreach ($this->items as $value => $label) {
            $item = new CheckboxItem(
                $index,
                $name,
                $value,
                ArrayHelper::isIn($value, $this->values),
                array_merge(
                    $this->checkboxAttributes,
                    $this->individualInputAttributes[$value] ?? [],
                    ['name' => $name, 'value' => $value]
                ),
                $label,
                $this->encodeLabels,
                $this->checkboxLabelAttributes,
                $this->checkboxLabelWrap,
            );
            $lines[] = $beforeCheckbox . $this->formatItem($item) . $afterCheckbox;
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
                            'disabled' => $this->checkboxAttributes['disabled'] ?? null,
                            'form' => $this->checkboxAttributes['form'] ?? null,
                        ],
                        $this->individualInputAttributes[$this->uncheckValue] ?? []
                    )
                )
                ->render();
    }

    private function formatItem(CheckboxItem $item): string
    {
        if ($this->itemFormatter !== null) {
            return ($this->itemFormatter)($item);
        }

        $checkbox = Html::checkbox($item->name, $item->value, $item->checkboxAttributes)
            ->checked($item->checked)
            ->label($item->label, $item->labelAttributes, $item->labelWrap)
            ->labelEncode($item->encodeLabel);

        return $checkbox->render();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
