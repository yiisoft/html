<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

abstract class ContentTag extends NormalTag implements ContentTagInterface
{
    use TagContentTrait;
}
