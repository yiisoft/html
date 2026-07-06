<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/text-level-semantics.html#the-q-element
 */
final class Q extends NormalTag
{
    use TagContentTrait;

    public function cite(?string $url): self
    {
        $new = clone $this;
        $new->attributes['cite'] = $url;
        return $new;
    }

    protected function getName(): string
    {
        return 'q';
    }
}
