<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/mfrac
 */
final class Mfrac extends AbstractMathItems
{
    protected function getName(): string
    {
        return 'mfrac';
    }

    public function linethickness(string|null $value): self
    {
        $new = clone $this;

        if ($value !== null) {
            $new->attributes['linethickness'] = $value;
        } else {
            unset($new->attributes['linethickness']);
        }

        return $new;
    }
}
