<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\BooleanInputTag;

final class TestBooleanInputTag extends BooleanInputTag
{
    protected function getType(): string
    {
        return 'test';
    }
}
