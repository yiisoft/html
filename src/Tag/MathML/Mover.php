<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

/**
 * https://developer.mozilla.org/en-US/docs/Web/MathML/Element/mover
 */
final class Mover extends AbstractMathItems
{
    public function getName(): string
    {
        return 'mover';
    }

    public function accent(bool $accent): self
    {
        $new = clone $this;
        $new->attributes['accent'] = $accent ? 'true' : 'false';

        return $new;
    }
}
