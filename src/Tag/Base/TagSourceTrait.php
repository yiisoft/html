<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Tag\Source;

/**
 * Adds functionality for processing tag with children source tags
 */
trait TagSourceTrait
{
    private array $sources = [];

    public function sources(?Source ...$sources): self
    {
        $new = clone $this;
        $new->sources = array_filter($sources, static fn ($source) => $source !== null);

        return $new;
    }

    public function addSource(Source $source): self
    {
        $new = clone $this;
        $new->sources[] = $source;

        return $new;
    }
}
