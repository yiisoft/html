<?php

declare(strict_types=1);

namespace Yiisoft\Html;

final class NoEncode implements NoEncodeStringableInterface
{
    private string $string;

    private function __construct(string $string)
    {
        $this->string = $string;
    }

    public static function string(string $value): self
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
