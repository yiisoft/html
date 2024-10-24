<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\CheckboxList;

use Stringable;

final class CheckboxItem
{
    public function __construct(
        public int $index,
        public string $name,
        public bool|float|int|string|Stringable|null $value,
        public bool $checked,
        public array $checkboxAttributes,
        public string $label,
        public bool $encodeLabel,
        public array $labelAttributes = [],
        public bool $labelWrap = true,
    ) {
    }
}
