<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Input;

use Yiisoft\Html\Tag\Base\BooleanInputTag;

final class Radio extends BooleanInputTag
{
    protected function getType(): string
    {
        return 'radio';
    }
}
