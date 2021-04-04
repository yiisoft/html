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
 * CheckboxList represents a list of checkboxes and their corresponding labels.
 */
final class CheckboxList implements NoEncodeStringableInterface
{
    private ?string $containerTag = 'div';
    private array $containerAttributes = [];
    private array $checkboxAttributes = [];
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

    public function checkboxAttributes(array $attributes): self
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
     * @param Closure(CheckboxItem):string|null $formatter
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
                array_merge($this->checkboxAttributes, [
                    'name' => $name,
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
        if (!empty($this->checkboxAttributes['disabled'])) {
            $input = $input->attribute('disabled', $this->checkboxAttributes['disabled']);
        }

        if (!empty($this->checkboxAttributes['form'])) {
            $input = $input->attribute('form', $this->checkboxAttributes['form']);
        }

        return $input->render();
    }

    private function formatItem(CheckboxItem $item): string
    {
        if ($this->itemFormatter !== null) {
            return ($this->itemFormatter)($item);
        }

        $checkbox = Html::checkbox($item->name, $item->value)
            ->attributes($item->checkboxAttributes)
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
