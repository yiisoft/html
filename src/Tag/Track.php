<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\VoidTag;

/**
 * @link https://html.spec.whatwg.org/multipage/media.html#the-track-element
 */
final class Track extends VoidTag
{
    public const SUBTITLES = 'subtitles';
    public const CAPTIONS = 'captions';
    public const DESCRIPTIONS = 'descriptions';
    public const CHAPTERS = 'chapters';
    public const METADATA = 'metadata';

    public function isDefault(): bool
    {
        return (bool) ($this->attributes['default'] ?? false);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-track-default
     */
    public function default(bool $default = true): self
    {
        return $this->attribute('default', $default);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-track-kind
     * @see self::SUBTITLES
     * @see self::CAPTIONS
     * @see self::DESCRIPTIONS
     * @see self::CHAPTERS
     * @see self::METADATA
     */
    public function kind(?string $kind): self
    {
        return $this->attribute('kind', $kind);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-track-label
     */
    public function label(?string $label): self
    {
        return $this->attribute('label', $label);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-track-src
     */
    public function src(string $src): self
    {
        return $this->attribute('src', $src);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-track-srclang
     */
    public function srclang(?string $srclang): self
    {
        return $this->attribute('srclang', $srclang);
    }

    protected function getName(): string
    {
        return 'track';
    }
}
