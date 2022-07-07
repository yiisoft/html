<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use InvalidArgumentException;
use RuntimeException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\Tag;

use function in_array;
use function is_array;

/**
 * The select element represents a control for selecting amongst a set of options.
 *
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-select-element
 */
final class Select extends NormalTag
{
    private array $items = [];
    private ?Option $prompt = null;
    private ?string $unselectValue = null;

    /**
     * @psalm-var list<string>
     */
    private array $values = [];

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-name
     *
     * @param string|null $name Name of the select input.
     *
     * @return Select
     */
    public function name(?string $name): self
    {
        $new = clone $this;
        $new->attributes['name'] = $name;
        return $new;
    }

    /**
     * @psalm-param \Stringable|scalar ...$value One or more string values.
     */
    public function value(...$value): self
    {
        $new = clone $this;
        $new->values = array_map('\strval', array_values($value));
        return $new;
    }

    /**
     * @psalm-param iterable<int, \Stringable|scalar> $values A set of values.
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
     *
     * @param string|null $formId ID of the form the select belongs to.
     *
     * @return self
     */
    public function form(?string $formId): self
    {
        $new = clone $this;
        $new->attributes['form'] = $formId;
        return $new;
    }

    /**
     * @param Optgroup|Option ...$items Select options or option groups.
     */
    public function items(Tag ...$items): self
    {
        $new = clone $this;
        $new->items = $items;
        return $new;
    }

    public function options(Option ...$options): self
    {
        return $this->items(...$options);
    }

    /**
     * @param array $data Options data. The array keys are option values, and the array values are the corresponding
     * option labels. The array can also be nested (i.e. some array values are arrays too). For each sub-array,
     * an option group will be generated whose label is the key associated with the sub-array.
     *
     * Example:
     * ```php
     * [
     *     '1' => 'Santiago',
     *     '2' => 'Concepcion',
     *     '3' => 'Chillan',
     *     '4' => 'Moscow'
     *     '5' => 'San Petersburg',
     *     '6' => 'Novosibirsk',
     *     '7' => 'Ekaterinburg'
     * ];
     * ```
     *
     * Example with options groups:
     * ```php
     * [
     *     '1' => [
     *         '1' => 'Santiago',
     *         '2' => 'Concepcion',
     *         '3' => 'Chillan',
     *     ],
     *     '2' => [
     *         '4' => 'Moscow',
     *         '5' => 'San Petersburg',
     *         '6' => 'Novosibirsk',
     *         '7' => 'Ekaterinburg'
     *     ],
     * ];
     * ```
     * @param bool $encode Whether option content should be HTML-encoded.
     * @param array[] $optionsAttributes Array of option attribute sets indexed by option values from {@see $data}.
     * @param array[] $groupsAttributes Array of group attribute sets indexed by group labels from {@see $data}.
     *
     * @psalm-param array<array-key, string|array<array-key,string>> $data
     *
     * @return self
     */
    public function optionsData(
        array $data,
        bool $encode = true,
        array $optionsAttributes = [],
        array $groupsAttributes = []
    ): self {
        $items = [];
        foreach ($data as $value => $content) {
            if (is_array($content)) {
                $items[] = Optgroup::tag()
                    ->label((string) $value)
                    ->addAttributes($groupsAttributes[$value] ?? [])
                    ->optionsData($content, $encode, $optionsAttributes);
            } else {
                $items[] = Option::tag()
                    ->replaceAttributes($optionsAttributes[$value] ?? [])
                    ->value($value)
                    ->content($content)
                    ->encode($encode);
            }
        }
        return $this->items(...$items);
    }

    /**
     * @param string|null $text Text of the option that has dummy value and is rendered
     * as an invitation to select a value.
     *
     * @return self
     */
    public function prompt(?string $text): self
    {
        $new = clone $this;
        $new->prompt = $text === null ? null : Option::tag()
            ->value('')
            ->content($text);
        return $new;
    }

    /**
     * @param Option|null $option Option that has dummy value and is rendered as an invitation to select a value.
     *
     * @return self
     */
    public function promptOption(?Option $option): self
    {
        $new = clone $this;
        $new->prompt = $option;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     *
     * @param bool $disabled Whether select input is disabled.
     *
     * @return self
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-select-multiple
     *
     * @param bool $multiple Whether to allow selecting multiple values.
     *
     * @return self
     */
    public function multiple(bool $multiple = true): self
    {
        $new = clone $this;
        $new->attributes['multiple'] = $multiple;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-select-required
     *
     * @param bool $required Whether select input is required.
     *
     * @return self
     */
    public function required(bool $required = true): self
    {
        $new = clone $this;
        $new->attributes['required'] = $required;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-select-size
     *
     * @param int|null $size The number of options to show to the user.
     *
     * @return self
     */
    public function size(?int $size): self
    {
        $new = clone $this;
        $new->attributes['size'] = $size;
        return $new;
    }

    /**
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function unselectValue($value): self
    {
        $new = clone $this;
        $new->unselectValue = $value === null ? null : (string)$value;
        return $new;
    }

    protected function prepareAttributes(): void
    {
        if (!empty($this->attributes['multiple']) && !empty($this->attributes['name'])) {
            $this->attributes['name'] = Html::getArrayableName((string)$this->attributes['name']);
        }
    }

    protected function generateContent(): string
    {
        $items = $this->items;
        if ($this->prompt) {
            array_unshift($items, $this->prompt);
        }

        $items = array_map(function ($item) {
            if ($item instanceof Option) {
                return $item->selected(in_array($item->getValue(), $this->values, true));
            }
            if ($item instanceof Optgroup) {
                return $item->selection(...$this->values);
            }
            throw new RuntimeException('Incorrect item into Select.');
        }, $items);

        return $items
            ? "\n" . implode("\n", $items) . "\n"
            : '';
    }

    protected function before(): string
    {
        $name = (string)($this->attributes['name'] ?? '');
        if (
            empty($name) ||
            (
                $this->unselectValue === null &&
                empty($this->attributes['multiple'])
            )
        ) {
            return '';
        }

        $input = Input::hidden(
            Html::getNonArrayableName($name),
            (string)$this->unselectValue
        );

        // Make sure disabled input is not sending any value.
        if (!empty($this->attributes['disabled'])) {
            $input = $input->attribute('disabled', $this->attributes['disabled']);
        }

        if (!empty($this->attributes['form'])) {
            $input = $input->attribute('form', $this->attributes['form']);
        }

        return $input->render() . "\n";
    }

    protected function getName(): string
    {
        return 'select';
    }
}
