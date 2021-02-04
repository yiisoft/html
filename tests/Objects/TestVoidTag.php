<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\VoidTag;

final class TestVoidTag extends VoidTag
{
    protected function getName(): string
    {
        return 'test';
    }
}
