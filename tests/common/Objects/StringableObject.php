<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

final class StringableObject implements \Stringable
{
    public function __construct(private string $string = 'string')
    {
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
