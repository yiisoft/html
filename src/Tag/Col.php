<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://www.w3.org/TR/html52/tabular-data.html#the-col-element
 */
final class Col extends VoidTag
{
    /**
     * @param int|null $number The number of consecutive columns the `<col>` element spans.
     */
    public function span(?int $number): self
    {
        $new = clone $this;
        $new->attributes['span'] = $number;
        return $new;
    }

    protected function getName(): string
    {
        return 'col';
    }
}
