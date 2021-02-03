<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

final class Hr extends VoidTag
{
    public static function tag(): self
    {
        return new self();
    }

    protected function getName(): string
    {
        return 'hr';
    }
}
