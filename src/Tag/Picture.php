<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagSourceTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/embedded-content.html#the-picture-element
 */
final class Picture extends NormalTag
{
    use TagSourceTrait;

    private ?Img $image = null;
    private array $imageAttributes = [];

    public function image(?Img $image): self
    {
        $new = clone $this;
        $new->image = $image;

        return $new;
    }

    public function imageAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->imageAttributes = $attributes;

        return $new;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return self
     */
    public function imageAttribute(string $name, $value): self
    {
        $new = clone $this;
        $new->imageAttributes[$name] = $value;

        return $new;
    }

    public function src(?string $src): self
    {
        if ($src) {
            return $this->image(Img::tag()->src($src));
        }

        return $this->image(null);
    }

    public function alt(string $alt): self
    {
        return $this->imageAttribute('alt', $alt);
    }

    /**
     * @param int|string|null $width
     *
     * @throws InvalidArgumentException
     *
     * @return self
     */
    public function width($width): self
    {
        if ($width !== null && !is_numeric($width)) {
            throw new InvalidArgumentException('Width must be null or numeric. "' . gettype($width) . '" given.');
        }

        return $this->imageAttribute('width', $width);
    }

    /**
     * @param int|string|null $height
     *
     * @throws InvalidArgumentException
     *
     * @return self
     */
    public function height($height): self
    {
        if ($height !== null && !is_numeric($height)) {
            throw new InvalidArgumentException('Width must be null or numeric. "' . gettype($height) . '" given.');
        }

        return $this->imageAttribute('height', $height);
    }

    protected function generateContent(): string
    {
        $content = '';

        /** @var array<array-key, Source> $this->sources */
        foreach ($this->sources as $source) {
            $content .= $source->render();
        }

        if ($this->image) {
            $content .= $this->image->attributes($this->imageAttributes)->render();
        }

        return $content;
    }

    protected function getName(): string
    {
        return 'picture';
    }
}
