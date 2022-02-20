<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Embedded;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Base\EmbeddedTag;
use Yiisoft\Html\Tag\Track;

/**
 * @link https://html.spec.whatwg.org/multipage/media.html#the-video-element
 */
final class Video extends EmbeddedTag
{
    private array $tracks = [];
    private bool $hasSrc = false;

    public function src(?string $src): self
    {
        $new = parent::src($src);
        $new->hasSrc = !empty($src);

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

    public function poster(?string $poster): self
    {
        return $this->attribute('poster', $poster);
    }

    public function width($width): self
    {
        if ($width !== null && !is_numeric($width)) {
            throw new InvalidArgumentException('Width must be null or numeric. "' . gettype($width) . '" given.');
        }

        return $this->attribute('width', $width);
    }

    public function height($height): self
    {
        if ($height !== null && !is_numeric($height)) {
            throw new InvalidArgumentException('Height must be null or numeric. "' . gettype($height) . '" given.');
        }

        return $this->attribute('height', $height);
    }

    protected function getName(): string
    {
        return 'video';
    }

    final protected function generateContent(): string
    {
        $content = '';
        $parts = $this->hasSrc ? $this->tracks : array_merge($this->sources, $this->tracks);

        foreach ($parts as $part) {
            $content .= $part->render();
        }

        if ($this->fallback) {
            $content .= $this->fallback;
        }

        return $content;
    }
}
