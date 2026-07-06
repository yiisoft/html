<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/text-level-semantics.html#the-time-element
 */
final class Time extends NormalTag
{
    use TagContentTrait;

    public function datetime(?string $datetime): self
    {
        $new = clone $this;
        $new->attributes['datetime'] = $datetime;
        return $new;
    }

    protected function getName(): string
    {
        return 'time';
    }
}
