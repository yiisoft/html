<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TableCellTag;

/**
 * @link https://www.w3.org/TR/html52/tabular-data.html#the-tr-element
 */
final class Tr extends NormalTag
{
    /**
     * @var TableCellTag[]
     */
    private array $items = [];

    /**
     * @param TableCellTag ...$cells One or more cells.
     */
    public function cells(TableCellTag ...$cells): self
    {
        $new = clone $this;
        $new->items = $cells;
        return $new;
    }

    /**
     * @param TableCellTag ...$cells One or more cells.
     */
    public function addCells(TableCellTag ...$cells): self
    {
        $new = clone $this;
        $new->items = array_merge($new->items, $cells);
        return $new;
    }

    /**
     * @param string[] $strings Array of data cells ({@see Td}) as strings.
     * @param array $attributes The tag attributes in terms of name-value pairs.
     * @param bool $encode Whether to encode strings passed.
     */
    public function dataStrings(array $strings, array $attributes = [], bool $encode = true): self
    {
        return $this->cells(...$this->makeDataCells($strings, $attributes, $encode));
    }

    /**
     * @param string[] $strings Array of data cells ({@see Td}) as strings.
     * @param array $attributes The tag attributes in terms of name-value pairs.
     * @param bool $encode Whether to encode strings passed.
     */
    public function addDataStrings(array $strings, array $attributes = [], bool $encode = true): self
    {
        return $this->addCells(...$this->makeDataCells($strings, $attributes, $encode));
    }

    /**
     * @param string[] $strings
     *
     * @return Td[]
     */
    private function makeDataCells(array $strings, array $attributes, bool $encode): array
    {
        return array_map(static function (string $string) use ($attributes, $encode) {
            return Td::tag()
                ->content($string)
                ->replaceAttributes($attributes)
                ->encode($encode);
        }, $strings);
    }

    /**
     * @param string[] $strings Array of header cells ({@see Th}) as strings.
     * @param array $attributes The tag attributes in terms of name-value pairs.
     * @param bool $encode Whether to encode strings passed.
     */
    public function headerStrings(array $strings, array $attributes = [], bool $encode = true): self
    {
        return $this->cells(...$this->makeHeaderCells($strings, $attributes, $encode));
    }

    /**
     * @param string[] $strings Array of header cells ({@see Th}) as strings.
     * @param array $attributes The tag attributes in terms of name-value pairs.
     * @param bool $encode Whether to encode strings passed.
     */
    public function addHeaderStrings(array $strings, array $attributes = [], bool $encode = true): self
    {
        return $this->addCells(...$this->makeHeaderCells($strings, $attributes, $encode));
    }

    /**
     * @param string[] $strings
     *
     * @return Th[]
     */
    private function makeHeaderCells(array $strings, array $attributes, bool $encode): array
    {
        return array_map(static function (string $string) use ($attributes, $encode) {
            return Th::tag()
                ->content($string)
                ->replaceAttributes($attributes)
                ->encode($encode);
        }, $strings);
    }

    protected function generateContent(): string
    {
        return $this->items
            ? "\n" . implode("\n", $this->items) . "\n"
            : '';
    }

    protected function getName(): string
    {
        return 'tr';
    }
}
