<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/#the-datalist-element
 */
final class Datalist extends NormalTag
{
    use TagContentTrait;

    protected function getName(): string
    {
        return 'datalist';
    }
}
