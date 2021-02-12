<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

final class StringableObject
{
    public function __toString(): string
    {
        return 'string';
    }
}
