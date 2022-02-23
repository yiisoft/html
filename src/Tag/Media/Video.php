<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Media;

use Yiisoft\Html\Tag\Base\MediaTag;

/**
 * @link https://html.spec.whatwg.org/multipage/media.html#the-video-element
 */
final class Video extends MediaTag
{
    /**
     * @param string|null $poster
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-video-poster
     *
     * @return self
     */
    public function poster(?string $poster): self
    {
        return $this->attribute('poster', $poster);
    }

    /**
     * @param int|string|null $width
     *
     * @link https://html.spec.whatwg.org/multipage/embedded-content-other.html#attr-dim-width
     *
     * @return self
     */
    public function width($width): self
    {
        return $this->attribute('width', $width);
    }

    /**
     * @param int|string|null $height
     *
     * @link https://html.spec.whatwg.org/multipage/embedded-content-other.html#attr-dim-height
     *
     * @return self
     */
    public function height($height): self
    {
        return $this->attribute('height', $height);
    }

    protected function getName(): string
    {
        return 'video';
    }
}
