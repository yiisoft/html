<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Stringable;
use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/mn
 */
final class Mn extends NormalTag implements MathItemInterface
{
    private string|int|float|Stringable $value;

    protected function getName(): string
    {
        return 'mn';
    }

    protected function generateContent(): string
    {
        return (string) $this->value;
    }

    public function value(string|int|float|Stringable $value): self
    {
        $new = clone $this;
        $new->value = $value;

        return $new;
    }
}
