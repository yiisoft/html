<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Yiisoft\Html\Tag\Base\VoidTag;

final class Mprescripts extends VoidTag
{
    protected function getName(): string
    {
        return 'mprescripts';
    }
}
