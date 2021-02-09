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

    protected function generateContent(): string
    {
        return $this->options
            ? $this->separator . implode($this->separator, $this->options) . $this->separator
            : '';
    }

    protected function getName(): string
    {
        return 'optgroup';
    }
}
