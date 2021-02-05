<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

final class Span extends NormalTag
{
    protected function getName(): string
    {
        return 'span';
    }
}
