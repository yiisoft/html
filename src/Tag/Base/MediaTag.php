<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;
use Yiisoft\Html\Tag\Track;

abstract class MediaTag extends NormalTag
{
    use TagSourcesTrait;

    /**
     * @psalm-suppress MissingClassConstType
     */
    final public const PRELOAD_NONE = 'none';

    /**
     * @psalm-suppress MissingClassConstType
     */
    final public const PRELOAD_METADATA = 'metadata';

    /**
     * @psalm-suppress MissingClassConstType
     */
    final public const PRELOAD_AUTO = 'auto';

    /**
     * @psalm-suppress MissingClassConstType
     */
    final public const CROSSORIGIN_ANONYMOUS = 'anonymous';

    /**
     * @psalm-suppress MissingClassConstType
     */
    final public const CROSSORIGIN_CREDENTIALS = 'use-credentials';

    private ?string $fallback = null;

    /**
     * @var Track[]
     */
    private array $tracks = [];

    /**
     * Content for browser that doesn't support media tags.
     */
    final public function fallback(string|Stringable|null $fallback): static
    {
        $new = clone $this;
        $new->fallback = $fallback === null ? null : (string) $fallback;
        return $new;
    }

    final public function tracks(Track ...$tracks): static
    {
        $new = clone $this;
        $new->tracks = $tracks;
        return $new;
    }

    final public function addTrack(Track $track): static
    {
        $new = clone $this;
        $new->tracks[] = $track;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-src
     */
    final public function src(?string $src): static
    {
        return $this->attribute('src', $src);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-crossorigin
     */
    final public function crossOrigin(?string $value): static
    {
        return $this->attribute('crossorigin', $value);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-preload
     */
    final public function preload(?string $preload): static
    {
        return $this->attribute('preload', $preload);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-muted
     */
    final public function muted(bool $muted = true): static
    {
        return $this->attribute('muted', $muted);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-loop
     */
    final public function loop(bool $loop = true): static
    {
        return $this->attribute('loop', $loop);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-autoplay
     */
    final public function autoplay(bool $autoplay = true): static
    {
        return $this->attribute('autoplay', $autoplay);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-autoplay
     */
    final public function controls(bool $controls = true): static
    {
        return $this->attribute('controls', $controls);
    }

    final protected function generateContent(): string
    {
        $items = $this->sources;

        $hasDefaultTrack = false;
        foreach ($this->tracks as $track) {
            $isDefault = $track->isDefault();
            if ($hasDefaultTrack && $isDefault) {
                $items[] = $track->default(false);
            } else {
                $items[] = $track;
                if (!$hasDefaultTrack) {
                    $hasDefaultTrack = $isDefault;
                }
            }
        }

        if ($this->fallback) {
            $items[] = $this->fallback;
        }

        return $items ? "\n" . implode("\n", $items) . "\n" : '';
    }
}
