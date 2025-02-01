<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/munder
 */
final class Munder extends AbstractMathItems
{
    protected function getName(): string
    {
        return 'munder';
    }

    public function accentunder(bool $accentunder): self
    {
        $new = clone $this;
        $new->attributes['accentunder'] = $accentunder ? 'true' : 'false';

        return $new;
    }
}
