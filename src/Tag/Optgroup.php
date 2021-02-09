<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ContainerTag;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-optgroup-element
 */
final class Optgroup extends ContainerTag
{
    private array $options = [];
    private string $separator = "\n";
    private array $selection = [];

    public function options(Option ...$options): self
    {
        $new = clone $this;
        $new->options = $options;
        return $new;
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
        return $this->options(...$options);
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-optgroup-label
     */
    public function label(?string $label): self
    {
        $new = clone $this;
        $new->attributes['label'] = $label;
        return $new;
    }

    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->separator = $separator;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-optgroup-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * @psalm-param \Stringable|scalar|null ...$value
     */
    public function selection(...$value): self
    {
        $new = clone $this;
        $new->selection = array_map('strval', $value);
        return $new;
    }

    protected function generateContent(): string
    {
        $options = array_map(function (Option $option) {
            return $option->selected(in_array($option->getValue(), $this->selection, true));
        }, $this->options);

        return $options
            ? $this->separator . implode($this->separator, $options) . $this->separator
            : '';
    }

    protected function getName(): string
    {
        return 'optgroup';
    }
}
