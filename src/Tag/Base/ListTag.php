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
     *
     * @return static
     */
    public function items(Li ...$items): self
    {
        $new = clone $this;
        $new->items = $items;
        return $new;
    }

    /**
     * @param string[] $strings Array of list items as strings.
     * @param array $attributes The tag attributes in terms of name-value pairs.
     * @param bool $encode Whether to encode strings passed.
     *
     * @return static
     */
    public function strings(array $strings, array $attributes = [], bool $encode = true): self
    {
        $items = array_map(static function (string $string) use ($attributes, $encode) {
            return Li::tag()
                ->content($string)
                ->replaceAttributes($attributes)
                ->encode($encode);
        }, $strings);
        return $this->items(...$items);
    }

    protected function generateContent(): string
    {
        return $this->items
            ? "\n" . implode("\n", $this->items) . "\n"
            : '';
    }
}
