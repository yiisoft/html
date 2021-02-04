<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\NormalTag;

final class TestNormalTag extends NormalTag
{
    protected function getName(): string
    {
        return 'test';
    }
}
