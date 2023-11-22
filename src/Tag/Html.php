<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/semantics.html#the-html-element
 */
final class Html extends NormalTag
{
    use TagContentTrait;

    protected function getName(): string
    {
        return 'html';
    }

    public function lang(?string $lang): self
    {
        $new = clone $this;
        $new->attributes['lang'] = $lang;
        return $new;
    }
}
