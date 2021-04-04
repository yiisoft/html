<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

final class TestTagContentTrait extends NormalTag
{
    use TagContentTrait;

    protected function getName(): string
    {
        return 'test';
    }
}
