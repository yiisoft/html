<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Tag;

final class TestTag extends Tag
{
    protected function getName(): string
    {
        return 'test';
    }

    public function __toString(): string
    {
        return '<' . $this->getName() . Html::renderTagAttributes($this->attributes) . '>';
    }
}
