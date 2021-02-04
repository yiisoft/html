<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

final class Hr extends VoidTag
{
    protected function getName(): string
    {
        return 'hr';
    }
}
