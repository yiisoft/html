<?php

declare(strict_types=1);

namespace Yiisoft\Html;

/**
 * The `NoEncode` class is designed to wrap content that should not be encoded in HTML tags.
 * For example:
 *
 * ```php
 * // The following will produce "<b><i>hello</i></b>"
 * echo Html:b(NoEncode::string('<i>hello</i>'));
 * ```
 */
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
