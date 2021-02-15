<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ContainerTag;

use function in_array;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-optgroup-element
 */
final class Optgroup extends ContainerTag
{
    private array $options = [];
    private array $selection = [];

    public function options(Option ...$options): self
    {
        $new = clone $this;
        $new->options = $options;
        return $new;
    }

    /**
     * Options as a set of value-content pairs.
     *
     * @param array<array-key, string> $data Value-content set of options.
     * @param bool $encode Whether to encode option content.
     *
     * @return self
     */
    public function optionsData(array $data, bool $encode = true): self
    {
        $options = [];
        foreach ($data as $value => $content) {
            $options[] = Option::tag()
                ->value($value)
                ->content($content)
                ->encode($encode);
        }
        return $this->options(...$options);
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-optgroup-label
     *
     * @param string|null $label
     *
     * @return self
     */
    public function label(?string $label): self
    {
        $new = clone $this;
        $new->attributes['label'] = $label;
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
     * @psalm-param \Stringable|scalar|null ...$value Values of options that are selected.
     *
     * @return self
     */
    public function selection(...$value): self
    {
        $new = clone $this;
        $new->selection = array_map('\strval', $value);
        return $new;
    }

    protected function generateContent(): string
    {
        $options = array_map(function (Option $option) {
            return $option->selected(in_array($option->getValue(), $this->selection, true));
        }, $this->options);

        return $options
            ? "\n" . implode("\n", $options) . "\n"
            : '';
    }

    protected function getName(): string
    {
        return 'optgroup';
    }
}
