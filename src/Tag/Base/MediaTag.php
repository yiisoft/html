<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Tag\Media\Track;
use Yiisoft\Html\Tag\Source;

abstract class MediaTag extends NormalTag
{
    use TagSourceTrait;

    private ?string $fallback = null;
    private array $tracks = [];

    /**
     * Content for browser who doesn't supported media tags
     *
     * @param string|Stringable|null $fallback
     *
     * @return static
     */
    public function fallback($fallback): self
    {
        if ($fallback !== null && !is_string($fallback) && $fallback instanceof Stringable === false) {
            throw new InvalidArgumentException('Content must be null, string or Stringable. "' . gettype($fallback) . ' given');
        }

        $new = clone $this;
        $new->fallback = $fallback ? (string) $fallback : null;

        return $new;
    }

    public function tracks(?Track ...$tracks): self
    {
        $new = clone $this;
        $new->tracks = array_filter($tracks, static fn ($track) => $track !== null);

        return $new;
    }

    public function addTrack(Track $track): self
    {
        $new = clone $this;
        $new->tracks[] = $track;

        return $new;
    }

    public function src(?string $src): self
    {
        return $this->attribute('src', $src);
    }

    public function crossorigin(?string $crossorigin): self
    {
        return $this->attribute('crossorigin', $crossorigin);
    }

    public function preload(?string $preload): self
    {
        return $this->attribute('preload', $preload);
    }

    public function muted(bool $muted = true): self
    {
        return $this->attribute('muted', $muted);
    }

    public function loop(bool $loop = true): self
    {
        return $this->attribute('loop', $loop);
    }

    public function autoplay(bool $autoplay = true): self
    {
        return $this->attribute('autoplay', $autoplay);
    }

    public function controls(bool $controls = true): self
    {
        return $this->attribute('controls', $controls);
    }

    final protected function generateContent(): string
    {
        $content = '';
        $hasDefaultTrack = false;

        if (!isset($this->attributes['src'])) {
            /** @var array<array-key, Source> $this->sources */
            foreach ($this->sources as $source) {
                $content .= $source;
            }
        }
        /** @var array<array-key, Track> $this->tracks */
        foreach ($this->tracks as $track) {
            if ($hasDefaultTrack && $track->isDefault()) {
                $content .= $track->default(false);
            } else {
                $content .= $track;

                if (!$hasDefaultTrack) {
                    $hasDefaultTrack = $track->isDefault();
                }
            }
        }

        if ($this->fallback) {
            $content .= $this->fallback;
        }

        return $content;
    }
}
