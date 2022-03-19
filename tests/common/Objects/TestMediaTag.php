<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\MediaTag;

final class TestMediaTag extends MediaTag
{
    protected function getName(): string
    {
        return 'test';
    }
}
