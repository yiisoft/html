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
        if (isset($this->attributes['default'])) {
            return $this->attributes['default'] !== false;
        }

        return false;
    }

    /**
     * @param bool $default
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-track-default
     *
     * @return self
     */
    public function default(bool $default = true): self
    {
        return $this->attribute('default', $default);
    }

    /**
     * @param string|null $kind
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-track-kind
     *
     * @return self
     */
    public function kind(?string $kind): self
    {
        return $this->attribute('kind', $kind);
    }

    /**
     * @param string|null $label
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-track-label
     *
     * @return self
     */
    public function label(?string $label): self
    {
        return $this->attribute('label', $label);
    }

    /**
     * @param string $src
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-track-src
     *
     * @return self
     */
    public function src(string $src): self
    {
        return $this->attribute('src', $src);
    }

    /**
     * @param string|null $srclang
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-track-srclang
     *
     * @return self
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
