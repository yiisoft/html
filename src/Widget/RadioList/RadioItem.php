<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\RadioList;

final class RadioItem
{
    public int $index;
    public string $name;

    /**
     * @var bool|float|int|string|\Stringable|null
     */
    public $value;

    public bool $checked;
    public array $radioAttributes;
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
        array $radioAttributes,
        string $label,
        bool $encodeLabel
    ) {
        $this->index = $index;
        $this->name = $name;
        $this->value = $value;
        $this->checked = $checked;
        $this->radioAttributes = $radioAttributes;
        $this->label = $label;
        $this->encodeLabel = $encodeLabel;
    }
}
