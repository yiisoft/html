<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/edits.html#the-del-element
 */
final class Del extends NormalTag
{
    use TagContentTrait;

    public function cite(?string $url): self
    {
        $new = clone $this;
        $new->attributes['cite'] = $url;
        return $new;
    }

    public function datetime(?string $datetime): self
    {
        $new = clone $this;
        $new->attributes['datetime'] = $datetime;
        return $new;
    }

    protected function getName(): string
    {
        return 'del';
    }
}
