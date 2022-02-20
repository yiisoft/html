<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Embedded;

use Yiisoft\Html\Tag\Base\EmbeddedTag;

/**
 * @link https://html.spec.whatwg.org/multipage/media.html#the-audio-element
 */
final class Audio extends EmbeddedTag
{
    protected function getName(): string
    {
        return 'audio';
    }
}
