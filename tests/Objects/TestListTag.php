<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\ListTag;

final class TestListTag extends ListTag
{
    protected function getName(): string
    {
        return 'test';
    }
}
