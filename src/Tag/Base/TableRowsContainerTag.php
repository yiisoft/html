<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Tag\Tr;

abstract class TableRowsContainerTag extends NormalTag
{
    /**
     * @var Tr[]
     */
    private array $rows = [];

    /**
     * @param Tr ...$rows One or more rows ({@see Tr}).
     */
    final public function rows(Tr ...$rows): static
    {
        $new = clone $this;
        $new->rows = $rows;
        return $new;
    }

    /**
     * @param Tr ...$rows One or more rows ({@see Tr}).
     */
    final public function addRows(Tr ...$rows): static
    {
        $new = clone $this;
        $new->rows = array_merge($new->rows, $rows);
        return $new;
    }

    final protected function generateContent(): string
    {
        return $this->rows
            ? "\n" . implode("\n", $this->rows) . "\n"
            : '';
    }
}
