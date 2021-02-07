<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\ListTag;

final class Ul extends ListTag
{
    protected function getName(): string
    {
        return 'ul';
    }
}
