<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

abstract class TableCellTag extends NormalTag
{
    use TagContentTrait;

    /**
     * Number of columns that the cell is to span.
     *
     * @return static
     */
    final public function colSpan(?int $number): self
    {
        $new = clone $this;
        $new->attributes['colspan'] = $number;
        return $new;
    }

    /**
     * Number of rows that the cell is to span.
     *
     * @return static
     */
    final public function rowSpan(?int $number): self
    {
        $new = clone $this;
        $new->attributes['rowspan'] = $number;
        return $new;
    }
}
