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
     * @param string|null $type
     *
     * @link https://html.spec.whatwg.org/multipage/embedded-content.html#attr-source-type
     *
     * @return self
     */
    public function type(?string $type): self
    {
        return $this->attribute('type', $type);
    }

    /**
     * @param string|null $src
     *
     * @link https://html.spec.whatwg.org/multipage/embedded-content.html#attr-source-src
     *
     * @return self
     */
    public function src(?string $src): self
    {
        return $this->attribute('src', $src);
    }

    /**
     * @param string|null $srcsets
     *
     * @link https://html.spec.whatwg.org/multipage/embedded-content.html#attr-source-srcset
     *
     * @return self
     */
    public function srcset(?string ...$srcsets): self
    {
        $items = array_diff($srcsets, ['']);

        return $this->attribute('srcset', $items ? implode(',', $items) : null);
    }

    /**
     * @param string|null $sizes
     *
     * @link https://html.spec.whatwg.org/multipage/embedded-content.html#attr-source-sizes
     *
     * @return self
     */
    public function sizes(?string ...$sizes): self
    {
        $items = array_diff($sizes, ['']);

        return $this->attribute('sizes', $items ? implode(',', $items) : null);
    }

    /**
     * @param string|null $media
     *
     * @link https://html.spec.whatwg.org/multipage/embedded-content.html#attr-source-media
     *
     * @return self
     */
    public function media(?string $media): self
    {
        return $this->attribute('media', $media);
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
        return 'source';
    }
}
