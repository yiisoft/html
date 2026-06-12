<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://html.spec.whatwg.org/multipage/iframe-embed-object.html#the-iframe-element
 */
final class Iframe extends NormalTag
{
    public function src(?string $url): self
    {
        $new = clone $this;
        $new->attributes['src'] = $url;
        return $new;
    }

    protected function getName(): string
    {
        return 'iframe';
    }

    protected function generateContent(): string
    {
        return '';
    }
}
