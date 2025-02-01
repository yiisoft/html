<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Override;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/mrow
 */
final class Mrow extends AbstractMathItems
{
    #[Override]
    protected function getName(): string
    {
        return 'mrow';
    }
}
