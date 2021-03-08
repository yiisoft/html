<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\NormalTag;

final class TestNormalTag extends NormalTag
{
    protected function generateContent(): string
    {
        return 'content';
    }

    protected function getName(): string
    {
        return 'test';
    }
}
