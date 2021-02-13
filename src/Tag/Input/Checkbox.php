<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Input;

use Yiisoft\Html\Tag\Base\BooleanInputTag;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#checkbox-state-typecheckbox
 */
final class Checkbox extends BooleanInputTag
{
    protected function getType(): string
    {
        return 'checkbox';
    }
}
