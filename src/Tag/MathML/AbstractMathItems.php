<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Yiisoft\Html\Tag\Base\NormalTag;

use function implode;

abstract class AbstractMathItems extends NormalTag implements MathItemInterface
{
    /**
     * @var MathItemInterface[]
     */
    protected array $items = [];

    protected function generateContent(): string
    {
        return $this->items
            ? "\n" . implode("\n", $this->items) . "\n"
            : '';
    }

    public function items(MathItemInterface ...$items): static
    {
        $new = clone $this;
        $new->items = $items;

        return $new;
    }
}
