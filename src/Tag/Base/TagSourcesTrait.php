<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Tag\Source;

/**
 * Adds functionality for processing tag with children {@see Source} tags.
 */
trait TagSourcesTrait
{
    /**
     * @var Source[]
     */
    private array $sources = [];

    /**
     * @return static
     */
    public function sources(Source ...$sources): self
    {
        $new = clone $this;
        $new->sources = $sources;
        return $new;
    }

    /**
     * @return static
     */
    public function addSource(Source $source): self
    {
        $new = clone $this;
        $new->sources[] = $source;
        return $new;
    }
}
