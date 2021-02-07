<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\ContainerTag;

final class TestContainerTag extends ContainerTag
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
