<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\MediaTag;

/**
 * @link https://html.spec.whatwg.org/multipage/media.html#the-video-element
 */
final class Video extends MediaTag
{
    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-video-poster
     */
    public function poster(?string $poster): self
    {
        return $this->attribute('poster', $poster);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/embedded-content-other.html#attr-dim-width
     */
    public function width(int|string|null $width): self
    {
        return $this->attribute('width', $width);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/embedded-content-other.html#attr-dim-height
     */
    public function height(int|string|null $height): self
    {
        return $this->attribute('height', $height);
    }

    protected function getName(): string
    {
        return 'video';
    }
}
