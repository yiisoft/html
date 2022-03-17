<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagSourcesTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/embedded-content.html#the-picture-element
 */
final class Picture extends NormalTag
{
    use TagSourcesTrait;

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
     * @return self
     */
    public function width($width): self
    {
        return $this->imageAttribute('width', $width);
    }

    /**
     * @param int|string|null $height
     *
     * @return self
     */
    public function height($height): self
    {
        return $this->imageAttribute('height', $height);
    }

    protected function generateContent(): string
    {
        $content = implode('', $this->sources);

        if ($this->image) {
            $content .= $this->image->attributes($this->imageAttributes);
        }

        return $content;
    }

    protected function getName(): string
    {
        return 'picture';
    }
}
