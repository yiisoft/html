<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget\RadioList;

use Stringable;

final class RadioItem
{
    public function __construct(
        public int $index,
        public string $name,
        public bool|float|int|string|Stringable|null $value,
        public bool $checked,
        public array $radioAttributes,
        public string $label,
        public bool $encodeLabel,
        public array $labelAttributes = [],
        public bool $labelWrap = true,
    ) {
    }
}
