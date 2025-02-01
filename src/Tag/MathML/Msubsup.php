<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/msubsup
 */
final class Msubsup extends AbstractMathItems
{
    public function getName(): string
    {
        return 'msubsup';
    }
}
