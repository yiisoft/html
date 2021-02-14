<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\BaseNormalTag;

final class TestBaseNormalTag extends BaseNormalTag
{
    public static function tag(): self
    {
        return new self();
    }

    protected function getName(): string
    {
        return 'test';
    }

    protected function renderTag(): string
    {
        return $this->open() . $this->generateContent() . $this->close();
    }
}
