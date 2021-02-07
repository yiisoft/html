<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

final class Ol extends ContainerTag
{
    private array $items = [];
    private string $separator = "\n";

    public function items(Li ...$items): self
    {
        $new = clone $this;
        $new->items = $items;
        return $new;
    }

    /**
     * @param string[] $strings
     */
    public function strings(array $strings, bool $encode = true): self
    {
        $items = array_map(function (string $string) use ($encode) {
            $item = Li::tag()->content($string);
            if (!$encode) {
                $item = $item->withoutEncode();
            }
            return $item;
        }, $strings);
        return $this->items(...$items);
    }

    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->separator = $separator;
        return $new;
    }

    protected function getName(): string
    {
        return 'ol';
    }

    protected function generateContent(): string
    {
        return $this->items
            ? $this->separator . implode($this->separator, $this->items) . $this->separator
            : '';
    }
}
