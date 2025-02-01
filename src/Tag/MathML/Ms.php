<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/ms
 */
final class Ms extends NormalTag implements MathItemInterface
{
    use TagContentTrait;

    public function getName(): string
    {
        return 'ms';
    }
}
