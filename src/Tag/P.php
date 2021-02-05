<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

final class P extends NormalTag
{
    protected function getName(): string
    {
        return 'p';
    }
}
