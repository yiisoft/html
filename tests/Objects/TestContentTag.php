<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\ContentTag;

final class TestContentTag extends ContentTag
{
    protected function getName(): string
    {
        return 'test';
    }
}
