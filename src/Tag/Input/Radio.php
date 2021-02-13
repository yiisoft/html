<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Input;

use Yiisoft\Html\Tag\Base\BooleanInputTag;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#radio-button-state-typeradio
 */
final class Radio extends BooleanInputTag
{
    protected function getType(): string
    {
        return 'radio';
    }
}
