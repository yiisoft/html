<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Embedded;

use InvalidArgumentException;
use Yiisoft\Html\Tag\Base\MediaTag;

/**
 * @link https://html.spec.whatwg.org/multipage/media.html#the-video-element
 */
final class Video extends MediaTag
{
    public function poster(?string $poster): self
    {
        return $this->attribute('poster', $poster);
    }

    /**
     * @param null|int|string $width
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

        return $this->attribute('width', $width);
    }

    /**
     * @param null|int|string $height
     *
     * @throws InvalidArgumentException
     *
     * @return self
     */
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
}
