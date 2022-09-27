<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\CheckboxList;

final class CheckboxItem
{
    /**
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function __construct(public int $index, public string $name, public $value, public bool $checked, public array $checkboxAttributes, public string $label, public bool $encodeLabel)
    {
    }
}
