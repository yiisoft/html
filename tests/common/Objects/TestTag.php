<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\Tag;

final class TestTag extends Tag
{
    public static function tag(): self
    {
        return new self();
    }

    public function getContent(): string
    {
        return '';
    }

    protected function getName(): string
    {
        return 'test';
    }

    protected function renderTag(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }
}
