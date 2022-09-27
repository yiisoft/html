<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\RadioList;

final class RadioItem
{
    /**
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function __construct(public int $index, public string $name, public $value, public bool $checked, public array $radioAttributes, public string $label, public bool $encodeLabel)
    {
    }
}
