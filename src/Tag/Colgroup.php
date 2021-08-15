<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://www.w3.org/TR/html52/tabular-data.html#the-colgroup-element
 */
final class Colgroup extends NormalTag
{
    /**
     * @var Col[]
     */
    private array $columns = [];

    /**
     * @param Col ...$columns One or more columns ({@see Col}).
     */
    public function columns(Col ...$columns): self
    {
        $new = clone $this;
        $new->columns = $columns;
        return $new;
    }

    /**
     * @param Col ...$columns One or more columns ({@see Col}).
     */
    public function addColumns(Col ...$columns): self
    {
        $new = clone $this;
        $new->columns = array_merge($new->columns, $columns);
        return $new;
    }

    /**
     * @param int|null $number The number of consecutive columns the `<colgroup>` element spans.
     */
    public function span(?int $number): self
    {
        $new = clone $this;
        $new->attributes['span'] = $number;
        return $new;
    }

    protected function generateContent(): string
    {
        return $this->columns
            ? "\n" . implode("\n", $this->columns) . "\n"
            : '';
    }

    protected function getName(): string
    {
        return 'colgroup';
    }
}
