<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Input;

use Yiisoft\Html\Tag\Base\BooleanInputTag;

final class Checkbox extends BooleanInputTag
{
    protected function getType(): string
    {
        return 'checkbox';
    }
}
