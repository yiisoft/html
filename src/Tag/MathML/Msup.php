<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Override;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/msup
 */
final class Msup extends AbstractMathItems
{
    #[Override]
    protected function getName(): string
    {
        return 'msup';
    }
}
