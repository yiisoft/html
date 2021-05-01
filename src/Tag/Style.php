<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://www.w3.org/TR/html52/document-metadata.html#the-style-element
 */
final class Style extends NormalTag
{
    private string $content = '';

    /**
     * @param string $content Tag content.
     *
     * @return static
     */
    public function content(string $content): self
    {
        $new = clone $this;
        $new->content = $content;
        return $new;
    }

    public function getContent(): string
    {
        return $this->content;
    }

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

    /**
     * @return string Obtain tag content.
     */
    protected function generateContent(): string
    {
        return $this->content;
    }
}
