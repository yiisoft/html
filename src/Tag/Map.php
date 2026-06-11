<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/image-maps.html#the-map-element
 */
final class Map extends NormalTag
{
    use TagContentTrait;

    protected function getName(): string
    {
        return 'map';
    }
}
