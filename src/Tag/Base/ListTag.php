<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

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
     * @param string[] $strings Array of list items as strings.
     * @param array $attributes The tag attributes in terms of name-value pairs.
     * @param bool $encode Whether to encode strings passed.
     */
    public function strings(array $strings, array $attributes = [], bool $encode = true): static
    {
        $items = array_map(
            static fn (string $string) => Li::tag()
                ->content($string)
                ->attributes($attributes)
                ->encode($encode),
            $strings
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
