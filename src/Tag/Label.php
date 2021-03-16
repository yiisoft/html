<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-label-element
 */
final class Label extends NormalTag
{
    use TagContentTrait;

    public function forId(?string $id): self
    {
        $new = clone $this;
        $new->attributes['for'] = $id;
        return $new;
    }

    protected function getName(): string
    {
        return 'label';
    }
}
