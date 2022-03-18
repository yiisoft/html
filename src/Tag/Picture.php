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

    public function image(?Img $image): self
    {
        $new = clone $this;
        $new->image = $image;
        return $new;
    }

    protected function generateContent(): string
    {
        $items = $this->sources;

        if ($this->image !== null) {
            $items[] = $this->image;
        }

        return $items ? "\n" . implode("\n", $items) . "\n" : '';
    }

    protected function getName(): string
    {
        return 'picture';
    }
}
