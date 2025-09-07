<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Input;

use Yiisoft\Html\Tag\Base\InputTag;

final class Color extends InputTag
{
    final protected function prepareAttributes(): void
    {
        $this->attributes['type'] = $this->getType();
    }

    protected function getType(): string
    {
        return 'color';
    }
}
