<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/msub
 */
final class Msub extends AbstractMathItems
{
    protected function getName(): string
    {
        return 'msub';
    }
}
