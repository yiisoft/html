<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

interface NotEncodeStringableInterface
{
    public function __toString(): string;
}
