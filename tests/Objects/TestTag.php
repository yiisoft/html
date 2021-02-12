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

    protected function getName(): string
    {
        return 'test';
    }

    public function render(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }
}
