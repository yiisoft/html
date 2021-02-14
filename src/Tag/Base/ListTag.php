<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Tag\Li;

/**
 * Base for list tags such as "ul" and "ol".
 */
abstract class ListTag extends ContainerTag
{
    private array $items = [];
    private string $separator = "\n";

    /**
     * @param Li ...$items One or more list items.
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
     * @param bool $encode Whether to encode strings passed.
     * @return static
     */
    public function strings(array $strings, bool $encode = true): self
    {
        $items = array_map(static function (string $string) use ($encode) {
            $item = Li::tag()->content($string);
            if (!$encode) {
                $item = $item->withoutEncode();
            }
            return $item;
        }, $strings);
        return $this->items(...$items);
    }

    /**
     * @param string $separator List item separator.
     * @return static
     */
    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->separator = $separator;
        return $new;
    }

    protected function generateContent(): string
    {
        return $this->items
            ? $this->separator . implode($this->separator, $this->items) . $this->separator
            : '';
    }
}
