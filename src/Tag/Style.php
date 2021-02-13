<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://www.w3.org/TR/html52/document-metadata.html#the-style-element
 */
final class Style extends NormalTag
{
    public function media(?string $media): self
    {
        $new = clone $this;
        $new->attributes['media'] = $media;
        return $new;
    }

    public function type(?string $type): self
    {
        $new = clone $this;
        $new->attributes['type'] = $type;
        return $new;
    }

    protected function getName(): string
    {
        return 'style';
    }
}
