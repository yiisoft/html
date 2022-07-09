<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\CheckboxList;

use Closure;
use InvalidArgumentException;
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
    private array $checkboxAttributes = [];

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

    /**
     * @psalm-var list<string>
     */
    private array $values = [];

    /**
     * @psalm-var Closure(CheckboxItem):string|null
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
     * @deprecated Use {@see addCheckboxAttributes()} or {@see replaceCheckboxAttributes()} instead. In the next major
     * version `replaceCheckboxAttributes()` method will be renamed to `checkboxAttributes()`.
     */
    public function checkboxAttributes(array $attributes): self
    {
        return $this->addCheckboxAttributes($attributes);
    }

    public function addCheckboxAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->checkboxAttributes = array_merge($new->checkboxAttributes, $attributes);
        return $new;
    }

    public function replaceCheckboxAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->checkboxAttributes = $attributes;
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
     *
     * @return self
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
     * @param scalar|\Stringable ...$value
     */
    public function value(...$value): self
    {
        $new = clone $this;
        $new->values = array_map('\strval', array_values($value));
        return $new;
    }

    /**
     * @psalm-param iterable<int, \Stringable|scalar> $values
     */
    public function values($values): self
    {
        /** @var mixed $values */
        if (!is_iterable($values)) {
            throw new InvalidArgumentException('$values should be iterable.');
        }

        /** @psalm-var iterable<int, \Stringable|scalar> $values */
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
            ->label($item->label)
            ->labelEncode($item->encodeLabel);

        return $checkbox->render();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
