<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\CheckboxList;

final class CheckboxItem
{
    public int $index;
    public string $name;

    /**
     * @var bool|float|int|string|\Stringable|null
     */
    public $value;

    public bool $checked;
    public array $checkboxAttributes;
    public string $label;
    public bool $encodeLabel;

    /**
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function __construct(
        int $index,
        string $name,
        $value,
        bool $checked,
        array $checkboxAttributes,
        string $label,
        bool $encodeLabel
    ) {
        $this->index = $index;
        $this->name = $name;
        $this->value = $value;
        $this->checked = $checked;
        $this->checkboxAttributes = $checkboxAttributes;
        $this->label = $label;
        $this->encodeLabel = $encodeLabel;
    }
}
