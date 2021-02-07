<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

final class Span extends NormalTag
{
    protected function getName(): string
    {
        return 'span';
    }
}
