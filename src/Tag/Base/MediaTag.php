<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Tag\Track;

abstract class MediaTag extends NormalTag
{
    use TagSourcesTrait;

    /**
     * Preload allowed values
     */
    public const PRELOAD_NONE = 'none';
    public const PRELOAD_METADATA = 'metadata';
    public const PRELOAD_AUTO = 'auto';

    /**
     * Crossorigin allowed values
     */
    public const CROSSORIGIN_ANONYMOUS = 'anonymous';
    public const CROSSORIGIN_CREDENTIALS = 'use-credentials';

    private ?string $fallback = null;
    /** @var array<array-key, Track> $tracks */
    private array $tracks = [];

    /**
     * Content for browser that doesn't support media tags
     *
     * @param mixed $fallback
     *
     * @return static
     */
    public function fallback($fallback): self
    {
        if ($fallback !== null && !\is_string($fallback) && !$fallback instanceof Stringable) {
            $value = \is_object($fallback) ? \get_class($fallback) : \gettype($fallback);
            throw new InvalidArgumentException('Fallback content  must be null, string or Stringable. "' . $value . ' given');
        }

        $new = clone $this;
        $new->fallback = $fallback ? (string) $fallback : null;

        return $new;
    }

    public function tracks(Track ...$tracks): self
    {
        $new = clone $this;
        $new->tracks = $tracks;

        return $new;
    }

    public function addTrack(Track $track): self
    {
        $new = clone $this;
        $new->tracks[] = $track;

        return $new;
    }

    /**
     * @param string|null $src
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-src
     *
     * @return static
     */
    public function src(?string $src): self
    {
        return $this->attribute('src', $src);
    }

    /**
     * @param string|null $crossorigin
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-crossorigin
     *
     * @return static
     */
    public function crossorigin(?string $crossorigin): self
    {
        return $this->attribute('crossorigin', $crossorigin);
    }

    /**
     * @param string|null $preload
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-preload
     *
     * @return static
     */
    public function preload(?string $preload): self
    {
        return $this->attribute('preload', $preload);
    }

    /**
     * @param bool $muted
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-muted
     *
     * @return static
     */
    public function muted(bool $muted = true): self
    {
        return $this->attribute('muted', $muted);
    }

    /**
     * @param bool $loop
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-loop
     *
     * @return static
     */
    public function loop(bool $loop = true): self
    {
        return $this->attribute('loop', $loop);
    }

    /**
     * @param bool $autoplay
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-autoplay
     *
     * @return static
     */
    public function autoplay(bool $autoplay = true): self
    {
        return $this->attribute('autoplay', $autoplay);
    }

    /**
     * @param bool $controls
     *
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-autoplay
     *
     * @return static
     */
    public function controls(bool $controls = true): self
    {
        return $this->attribute('controls', $controls);
    }

    final protected function generateContent(): string
    {
        $content = '';
        $hasDefaultTrack = false;

        if (!isset($this->attributes['src'])) {
            $content .= implode('', $this->sources);
        }

        foreach ($this->tracks as $track) {
            $isDefault = $track->isDefault();
            if ($hasDefaultTrack && $isDefault) {
                $content .= $track->default(false);
            } else {
                $content .= $track;

                if (!$hasDefaultTrack) {
                    $hasDefaultTrack = $isDefault;
                }
            }
        }

        if ($this->fallback) {
            $content .= $this->fallback;
        }

        return $content;
    }
}
