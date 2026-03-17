<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;
use Yiisoft\Html\Tag\Li;

/**
 * Base for list tags such as "ul" and "ol".
 */
abstract class ListTag extends NormalTag
{
    /**
     * @var Li[]
     */
    private array $items = [];

    /**
     * @param Li ...$items One or more list items.
     */
    public function items(Li ...$items): static
    {
        $new = clone $this;
        $new->items = $items;
        return $new;
    }

    /**
     * @param (string|Stringable|int|float|null)[] $strings Array of list item contents.
     * @param array $attributes The tag attributes in terms of name-value pairs.
     * @param bool $encode Whether to encode the item contents when rendering.
     */
    public function strings(array $strings, array $attributes = [], bool $encode = true): static
    {
        $items = array_map(
            static fn(string|Stringable|int|float|null $string) => (new Li())
                ->content($string)
                ->attributes($attributes)
                ->encode($encode),
            $strings,
        );
        return $this->items(...$items);
    }

    protected function generateContent(): string
    {
        return $this->items
            ? "\n" . implode("\n", $this->items) . "\n"
            : '';
    }
}
