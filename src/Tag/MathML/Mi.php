<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Stringable;
use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/mi
 */
final class Mi extends NormalTag implements MathItemInterface
{
    private string|Stringable $identifier;

    protected function getName(): string
    {
        return 'mi';
    }

    protected function generateContent(): string
    {
        return (string) $this->identifier;
    }

    public function identifier(string|Stringable $identifier): self
    {
        $new = clone $this;
        $new->identifier = $identifier;

        return $new;
    }

    public function normal(bool $normal): self
    {
        $new = clone $this;

        if ($normal) {
            $new->attributes['mathvariant'] = 'normal';
        } else {
            unset($new->attributes['mathvariant']);
        }

        return $new;
    }
}
