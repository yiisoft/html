<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/grouping-content.html#the-blockquote-element
 */
final class Blockquote extends NormalTag
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
        return 'blockquote';
    }
}
