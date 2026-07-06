<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/text-level-semantics.html#the-data-element
 */
final class Data extends NormalTag
{
    use TagContentTrait;

    public function value(?string $value): self
    {
        $new = clone $this;
        $new->attributes['value'] = $value;
        return $new;
    }

    protected function getName(): string
    {
        return 'data';
    }
}
