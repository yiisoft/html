<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Embedded;

use Yiisoft\Html\Tag\Base\EmbeddedTag;
use Yiisoft\Html\Tag\Img;

/**
 * @link https://html.spec.whatwg.org/multipage/embedded-content.html#the-picture-element
 */
final class Picture extends EmbeddedTag
{
    private ?Img $image = null;

    public function image(?Img $image): self
    {
        $new = clone $this;
        $new->image = $image;

        return $new;
    }

    public function src(?string $src): self
    {
        if ($src) {
            return $this->image(Img::tag()->src($src));
        }

        return $this->image(null);
    }

    final protected function generateContent(): string
    {
        $content = '';

        foreach ($this->sources as $source) {
            $content .= $source->render();
        }

        if ($this->image) {
            $content .= $this->image->render();
        }

        return $content;
    }


    protected function getName(): string
    {
        return 'picture';
    }
}
