<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Tag\Track;

use function get_class;
use function gettype;
use function is_object;
use function is_string;

abstract class MediaTag extends NormalTag
{
    use TagSourcesTrait;

    /**
     * The "preload" attribute allowed values.
     */
    public const PRELOAD_NONE = 'none';
    public const PRELOAD_METADATA = 'metadata';
    public const PRELOAD_AUTO = 'auto';

    /**
     * The "crossorigin" attribute allowed values.
     */
    public const CROSSORIGIN_ANONYMOUS = 'anonymous';
    public const CROSSORIGIN_CREDENTIALS = 'use-credentials';

    private ?string $fallback = null;

    /**
     * @var Track[]
     */
    private array $tracks = [];

    /**
     * Content for browser that doesn't support media tags.
     *
     * @param string|Stringable|null $fallback
     *
     * @return static
     */
    final public function fallback($fallback): self
    {
        if ($fallback !== null && !is_string($fallback) && !$fallback instanceof Stringable) {
            /** @psalm-suppress RedundantConditionGivenDocblockType,DocblockTypeContradiction */
            $value = is_object($fallback) ? get_class($fallback) : gettype($fallback);
            throw new InvalidArgumentException(
                'Fallback content must be null, string or Stringable. "' . $value . '" given.'
            );
        }

        $new = clone $this;
        $new->fallback = $fallback === null ? null : (string) $fallback;
        return $new;
    }

    /**
     * @return static
     */
    final public function tracks(Track ...$tracks): self
    {
        $new = clone $this;
        $new->tracks = $tracks;
        return $new;
    }

    /**
     * @return static
     */
    final public function addTrack(Track $track): self
    {
        $new = clone $this;
        $new->tracks[] = $track;
        return $new;
    }

    /**
     *s @link https://html.spec.whatwg.org/multipage/media.html#attr-media-src
     *
     * @return static
     */
    final public function src(?string $src): self
    {
        return $this->attribute('src', $src);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-crossorigin
     *
     * @return static
     */
    final public function crossOrigin(?string $value): self
    {
        return $this->attribute('crossorigin', $value);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-preload
     *
     * @return static
     */
    final public function preload(?string $preload): self
    {
        return $this->attribute('preload', $preload);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-muted
     *
     * @return static
     */
    final public function muted(bool $muted = true): self
    {
        return $this->attribute('muted', $muted);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-loop
     *
     * @return static
     */
    final public function loop(bool $loop = true): self
    {
        return $this->attribute('loop', $loop);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-autoplay
     *
     * @return static
     */
    final public function autoplay(bool $autoplay = true): self
    {
        return $this->attribute('autoplay', $autoplay);
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/media.html#attr-media-autoplay
     *
     * @return static
     */
    final public function controls(bool $controls = true): self
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
