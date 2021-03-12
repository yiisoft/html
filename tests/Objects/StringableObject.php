<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

final class StringableObject
{
    private string $string;

    public function __construct(string $string = 'string')
    {
        $this->string = $string;
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
