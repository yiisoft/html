<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\MediaTag;

/**
 * @link https://html.spec.whatwg.org/multipage/media.html#the-audio-element
 */
final class Audio extends MediaTag
{
    protected function getName(): string
    {
        return 'audio';
    }
}
