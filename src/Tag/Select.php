<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Base\ContainerTag;
use Yiisoft\Html\Tag\Base\Tag;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-select-element
 */
final class Select extends ContainerTag
{
    private array $items = [];
    private ?Option $prompt = null;
    private string $separator = "\n";

    /**
     * @psalm-var list<string>
     */
    private array $values = [];

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-name
     */
    public function name(?string $name): self
    {
        $new = clone $this;
        $new->attributes['name'] = $name;
        return $new;
    }

    /**
     * @psalm-param \Stringable|scalar|null ...$value
     */
    public function value(...$value): self
    {
        $new = clone $this;
        $new->values = array_map('strval', $value);
        return $new;
    }

    /**
     * @psalm-param iterable<array-key, \Stringable|scalar|null> $values
     */
    public function values($values): self
    {
        /** @var mixed $values */
        if (!is_iterable($values)) {
            throw new InvalidArgumentException('$values should be iterable.');
        }

        /** @psalm-var iterable<array-key, \Stringable|scalar|null> $values */
        $values = is_array($values) ? $values : iterator_to_array($values);

        return $this->value(...$values);
    }

    /**
     * @param Optgroup|Option ...$items
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
     * @param array<array-key, string> $data
     */
    public function optionsData(array $data, bool $encode = true): self
    {
        $options = [];
        foreach ($data as $value => $content) {
            $option = Option::tag()->value((string)$value)->content($content);
            if (!$encode) {
                $option = $option->withoutEncode();
            }
            $options[] = $option;
        }
        return $this->items(...$options);
    }

    public function prompt(?string $text): self
    {
        $new = clone $this;
        $new->prompt = $text === null ? null : Option::tag()->value('')->content($text);
        return $new;
    }

    public function promptOption(?Option $option): self
    {
        $new = clone $this;
        $new->prompt = $option;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-select-multiple
     */
    public function multiple(bool $multiple = true): self
    {
        $new = clone $this;
        $new->attributes['multiple'] = $multiple;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-select-required
     */
    public function required(bool $required = true): self
    {
        $new = clone $this;
        $new->attributes['required'] = $required;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-select-size
     */
    public function size(?int $size): self
    {
        $new = clone $this;
        $new->attributes['size'] = $size;
        return $new;
    }

    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->separator = $separator;
        return $new;
    }

    protected function generateContent(): string
    {
        $items = $this->items;
        if ($this->prompt) {
            array_unshift($items, $this->prompt);
        }

        /** @var Optgroup[]|Option[] $items */

        $items = array_map(function ($item) {
            if ($item instanceof Option) {
                return $item->selected(in_array($item->getValue(), $this->values, true));
            }
            if ($item instanceof Optgroup) {
                return $item->separator($this->separator)->selection(...$this->values);
            }
            return $item;
        }, $items);

        return $items
            ? $this->separator . implode($this->separator, $items) . $this->separator
            : '';
    }

    protected function getName(): string
    {
        return 'select';
    }
}
