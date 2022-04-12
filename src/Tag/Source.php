<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://html.spec.whatwg.org/multipage/embedded-content.html#the-source-element
 */
final class Source extends VoidTag
{
    /**
     * @link https://html.spec.whatwg.org/multipage/embedded-content.html#attr-source-type
     */
    public function type(?string $type): self
    {
        return $this->attribute('type', $type);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/embedded-content.html#attr-source-src
     */
    public function src(?string $src): self
    {
        return $this->attribute('src', $src);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/embedded-content.html#attr-source-srcset
     */
    public function srcset(?string ...$srcsets): self
    {
        $items = array_diff($srcsets, [null]);

        return $this->attribute('srcset', $items ? implode(',', $items) : null);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/embedded-content.html#attr-source-sizes
     */
    public function sizes(?string ...$sizes): self
    {
        $items = array_diff($sizes, [null]);

        return $this->attribute('sizes', $items ? implode(',', $items) : null);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/embedded-content.html#attr-source-media
     */
    public function media(?string $media): self
    {
        return $this->attribute('media', $media);
    }

    /**
     * @param int|string|null $width
     *
     * @link https://html.spec.whatwg.org/multipage/embedded-content-other.html#attr-dim-width
     */
    public function width($width): self
    {
        return $this->attribute('width', $width);
    }

    /**
     * @param int|string|null $height
     *
     * @link https://html.spec.whatwg.org/multipage/embedded-content-other.html#attr-dim-height
     */
    public function height($height): self
    {
        return $this->attribute('height', $height);
    }

    protected function getName(): string
    {
        return 'source';
    }
}
