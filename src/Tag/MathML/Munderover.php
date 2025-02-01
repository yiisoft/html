<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/munderover
 */
final class Munderover extends AbstractMathItems
{
    protected function getName(): string
    {
        return 'munderover';
    }

    public function accent(bool $accent = true): self
    {
        $new = clone $this;
        $new->attributes['accent'] = $accent ? 'true' : 'false';

        return $new;
    }

    public function accentunder(bool $accentunder = true): self
    {
        $new = clone $this;
        $new->attributes['accentunder'] = $accentunder ? 'true' : 'false';

        return $new;
    }
}
