<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://html.spec.whatwg.org/multipage/document-metadata.html#the-base-element
 */
final class Base extends VoidTag
{
    public function href(?string $url): self
    {
        $new = clone $this;
        $new->attributes['href'] = $url;
        return $new;
    }

    public function target(?string $target): self
    {
        $new = clone $this;
        $new->attributes['target'] = $target;
        return $new;
    }

    protected function getName(): string
    {
        return 'base';
    }
}
