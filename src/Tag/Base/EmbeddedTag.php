<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;
use InvalidArgumentException;
use Yiisoft\Html\Tag\Source;

abstract class EmbeddedTag extends NormalTag
{
    protected ?string $fallback = null;
    protected array $sources = [];

    /**
     *
     * @param null|string|Stringable $content
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

    public function sources(?Source ...$sources): self
    {
        $new = clone $this;
        $new->sources = array_filter($sources, static fn ($source) => $source !== null);

        return $new;
    }

    public function addSource(Source $source): self
    {
        $new = clone $this;
        $new->sources[] = $source;

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

    public function muted(bool $muted): self
    {
        return $this->attribute('muted', $muted);
    }

    public function loop(bool $loop): self
    {
        return $this->attribute('loop', $loop);
    }

    public function autoplay(bool $autoplay): self
    {
        return $this->attribute('autoplay', $autoplay);
    }

    public function controls(bool $controls): self
    {
        return $this->attribute('controls', $controls);
    }

    protected function generateContent(): string
    {
        $content = '';

        foreach ($this->sources as $source) {
            $content .= $source->render();
        }

        if ($this->fallback) {
            $content = $this->fallback;
        }

        return $content;
    }
}
