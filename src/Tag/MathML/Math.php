<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Yiisoft\Html\Tag\Base\NormalTag;

use function implode;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/math
 */
final class Math extends NormalTag
{
    /**
     * @var MathItemInterface[]
     */
    private array $items = [];

    protected function getName(): string
    {
        return 'math';
    }

    protected function generateContent(): string
    {
        return $this->items
            ? "\n" . implode("\n", $this->items) . "\n"
            : '';
    }

    public function items(MathItemInterface ...$items): self
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }

    public function block(): self
    {
        $new = clone $this;
        $new->attributes['display'] = 'block';

        return $new;
    }

    public function inline(): self
    {
        $new = clone $this;
        unset($new->attributes['display']);

        return $new;
    }
}
