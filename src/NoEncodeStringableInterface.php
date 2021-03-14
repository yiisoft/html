<?php

declare(strict_types=1);

namespace Yiisoft\Html;

interface NoEncodeStringableInterface
{
    public function __toString(): string;
}
