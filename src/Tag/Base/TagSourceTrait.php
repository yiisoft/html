<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Tag\Source;

/**
 * Adds functionality for processing tag with children source tags
 */
trait TagSourceTrait
{
    /** @var array<array-key, Source> $sources */
    private array $sources = [];

    public function sources(Source ...$sources): self
    {
        $new = clone $this;
        $new->sources = $sources;

        return $new;
    }

    public function addSource(Source $source): self
    {
        $new = clone $this;
        $new->sources[] = $source;

        return $new;
    }
}
