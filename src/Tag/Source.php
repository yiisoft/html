<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://html.spec.whatwg.org/multipage/embedded-content.html#the-source-element
 */
final class Source extends VoidTag
{
    public function type(string $type): self
    {
        return $this->attribute('type', $type);
    }

    public function src(string $src): self
    {
        return $this->attribute('src', $src);
    }

    public function srcset(?string ...$srcsets): self
    {
        $items = array_diff($srcsets, ['']);

        return $this->attribute('srcset', $items ? implode(',', $items) : null);
    }

    public function sizes(?string ...$sizes): self
    {
        $items = array_diff($srcsets, ['']);

        return $this->attribute('sizes', $items ? implode(',', $items) : null);
    }

    public function media(string $media): self
    {
        return $this->attribute('media', $media);
    }

    /**
     * @param int|string|null $width
     */
    public function width($width): self
    {
        if ($width !== null && !is_numeric($width)) {
            throw new InvalidArgumentException('Width must be null or numeric. "' . gettype($width) . '" given.');
        }

        return $this->attribute('width', $width);
    }

    /**
     * @param int|string|null $height
     */
    public function height($height): self
    {
        if ($height !== null && !is_numeric($height)) {
            throw new InvalidArgumentException('Height must be null or numeric. "' . gettype($height) . '" given.');
        }

        return $this->attribute('height', $height);
    }

    protected function getName(): string
    {
        return 'source';
    }
}
