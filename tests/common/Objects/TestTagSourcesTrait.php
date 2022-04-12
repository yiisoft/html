<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagSourcesTrait;

final class TestTagSourcesTrait extends NormalTag
{
    use TagSourcesTrait;

    protected function generateContent(): string
    {
        return $this->sources
            ? "\n" . implode("\n", $this->sources) . "\n"
            : '';
    }

    protected function getName(): string
    {
        return 'test';
    }
}
