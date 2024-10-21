<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\VoidTag;

final class TestVoidTag extends VoidTag
{
    protected function getName(): string
    {
        return 'test';
    }
}
